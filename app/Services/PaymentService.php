<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;

class PaymentService
{
    protected $stripeSecret;
    protected $paypalClientId;
    protected $paypalSecret;
    protected $sslCommerzStoreId;
    protected $sslCommerzStorePassword;

    public function __construct()
    {
        $this->stripeSecret = config('services.stripe.secret');
        $this->paypalClientId = config('services.paypal.client_id');
        $this->paypalSecret = config('services.paypal.secret');
        $this->sslCommerzStoreId = config('services.sslcommerz.store_id');
        $this->sslCommerzStorePassword = config('services.sslcommerz.store_password');
    }

    /**
     * Create payment intent with Stripe
     */
    public function createStripePayment(array $data): array
    {
        try {
            $response = Http::withToken($this->stripeSecret)
                ->asForm()
                ->post('https://api.stripe.com/v1/payment_intents', [
                    'amount' => $data['amount'] * 100, // Convert to cents
                    'currency' => $data['currency'] ?? 'usd',
                    'payment_method' => $data['payment_method_id'],
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                    'metadata' => [
                        'user_id' => $data['user_id'],
                        'type' => $data['type'],
                        'payable_id' => $data['payable_id'],
                        'payable_type' => $data['payable_type'],
                    ],
                ]);

            $paymentIntent = $response->json();

            if (!$response->successful()) {
                throw new \Exception($paymentIntent['error']['message'] ?? 'Stripe payment failed');
            }

            // Create payment record
            $payment = $this->createPaymentRecord([
                'user_id' => $data['user_id'],
                'payable_type' => $data['payable_type'],
                'payable_id' => $data['payable_id'],
                'gateway' => 'stripe',
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'USD',
                'status' => $paymentIntent['status'] === 'succeeded' ? 'completed' : 'pending',
                'gateway_transaction_id' => $paymentIntent['id'],
                'gateway_response' => $paymentIntent,
            ]);

            return [
                'success' => true,
                'payment' => $payment,
                'client_secret' => $paymentIntent['client_secret'] ?? null,
                'requires_action' => $paymentIntent['status'] === 'requires_action',
                'next_action' => $paymentIntent['next_action'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe payment error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create payment with SSLCommerz
     */
    public function createSSLCommerzPayment(array $data): array
    {
        try {
            $transactionId = 'TXN' . time() . rand(1000, 9999);
            
            $postData = [
                'store_id' => $this->sslCommerzStoreId,
                'store_passwd' => $this->sslCommerzStorePassword,
                'total_amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'BDT',
                'tran_id' => $transactionId,
                'success_url' => route('payment.sslcommerz.success'),
                'fail_url' => route('payment.sslcommerz.fail'),
                'cancel_url' => route('payment.sslcommerz.cancel'),
                'ipn_url' => route('payment.sslcommerz.ipn'),
                'cus_name' => $data['customer_name'] ?? 'Customer',
                'cus_email' => $data['customer_email'],
                'cus_phone' => $data['customer_phone'] ?? '',
                'cus_add1' => $data['customer_address'] ?? '',
                'cus_city' => $data['customer_city'] ?? '',
                'cus_country' => $data['customer_country'] ?? '',
                'shipping_method' => 'NO',
                'product_name' => $data['description'] ?? 'Payment',
                'product_category' => 'Service',
                'product_profile' => 'service',
                'multi_card_name' => 'sslcommerz',
                'value_a' => $data['user_id'],
                'value_b' => $data['payable_type'],
                'value_c' => $data['payable_id'],
            ];

            $response = Http::asForm()->post('https://securepay.sslcommerz.com/gwprocess/v4/api.php', $postData);
            $result = $response->json();

            if ($result['status'] !== 'SUCCESS') {
                throw new \Exception($result['failedreason'] ?? 'SSLCommerz payment initiation failed');
            }

            // Create payment record
            $payment = $this->createPaymentRecord([
                'user_id' => $data['user_id'],
                'payable_type' => $data['payable_type'],
                'payable_id' => $data['payable_id'],
                'gateway' => 'sslcommerz',
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'BDT',
                'status' => 'pending',
                'gateway_transaction_id' => $transactionId,
                'gateway_response' => $result,
            ]);

            return [
                'success' => true,
                'payment' => $payment,
                'gateway_url' => $result['GatewayPageURL'],
                'transaction_id' => $transactionId,
            ];
        } catch (\Exception $e) {
            Log::error('SSLCommerz payment error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create payment with PayPal
     */
    public function createPayPalPayment(array $data): array
    {
        try {
            $accessToken = $this->getPayPalAccessToken();
            
            $orderData = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $data['currency'] ?? 'USD',
                            'value' => number_format($data['amount'], 2, '.', ''),
                        ],
                        'reference_id' => $data['payable_id'],
                        'custom_id' => $data['user_id'] . '|' . $data['payable_type'] . '|' . $data['payable_id'],
                    ],
                ],
                'application_context' => [
                    'return_url' => route('payment.paypal.success'),
                    'cancel_url' => route('payment.paypal.cancel'),
                    'brand_name' => config('app.name'),
                    'landing_page' => 'BILLING',
                    'user_action' => 'PAY_NOW',
                ],
            ];

            $response = Http::withToken($accessToken)
                ->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', $orderData);

            $order = $response->json();

            if (!$response->successful()) {
                throw new \Exception($order['message'] ?? 'PayPal payment creation failed');
            }

            // Create payment record
            $payment = $this->createPaymentRecord([
                'user_id' => $data['user_id'],
                'payable_type' => $data['payable_type'],
                'payable_id' => $data['payable_id'],
                'gateway' => 'paypal',
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'USD',
                'status' => 'pending',
                'gateway_transaction_id' => $order['id'],
                'gateway_response' => $order,
            ]);

            return [
                'success' => true,
                'payment' => $payment,
                'order_id' => $order['id'],
                'approval_url' => collect($order['links'])->firstWhere('rel', 'approve')['href'],
            ];
        } catch (\Exception $e) {
            Log::error('PayPal payment error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify SSLCommerz payment
     */
    public function verifySSLCommerzPayment(array $data): bool
    {
        try {
            $response = Http::asForm()->post('https://securepay.sslcommerz.com/validator/api/validationserverAPI.php', [
                'val_id' => $data['val_id'],
                'store_id' => $this->sslCommerzStoreId,
                'store_passwd' => $this->sslCommerzStorePassword,
                'format' => 'json',
            ]);

            $result = $response->json();
            
            return $result['status'] === 'VALID' && $result['tran_status'] === 'SUCCESS';
        } catch (\Exception $e) {
            Log::error('SSLCommerz verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Capture PayPal payment
     */
    public function capturePayPalPayment(string $orderId): array
    {
        try {
            $accessToken = $this->getPayPalAccessToken();
            
            $response = Http::withToken($accessToken)
                ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderId}/capture");

            $result = $response->json();

            if (!$response->successful()) {
                throw new \Exception($result['message'] ?? 'PayPal capture failed');
            }

            $capture = collect($result['purchase_units'][0]['payments']['captures'])->first();

            return [
                'success' => true,
                'status' => $capture['status'],
                'transaction_id' => $capture['id'],
                'amount' => $capture['amount']['value'],
                'currency' => $capture['amount']['currency_code'],
                'response' => $result,
            ];
        } catch (\Exception $e) {
            Log::error('PayPal capture error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Payment $payment, string $status, array $gatewayResponse = []): Payment
    {
        $payment->update([
            'status' => $status,
            'gateway_response' => array_merge($payment->gateway_response ?? [], $gatewayResponse),
            'completed_at' => $status === 'completed' ? now() : null,
        ]);

        // Create transaction record
        if ($status === 'completed') {
            Transaction::create([
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'gateway' => $payment->gateway,
                'gateway_transaction_id' => $payment->gateway_transaction_id,
                'type' => 'payment',
                'status' => 'completed',
                'description' => "Payment for {$payment->payable_type} #{$payment->payable_id}",
            ]);
        }

        return $payment;
    }

    /**
     * Handle failed payments
     */
    public function handleFailedPayment(Payment $payment, string $reason = ''): void
    {
        $this->updatePaymentStatus($payment, 'failed', [
            'failure_reason' => $reason,
            'failed_at' => now()->toISOString(),
        ]);

        Log::warning("Payment failed: {$payment->gateway_transaction_id} - {$reason}");
    }

    /**
     * Handle refund
     */
    public function processRefund(Payment $payment, float $amount = null): array
    {
        try {
            $refundAmount = $amount ?? $payment->amount;

            switch ($payment->gateway) {
                case 'stripe':
                    return $this->stripeRefund($payment, $refundAmount);
                case 'paypal':
                    return $this->paypalRefund($payment, $refundAmount);
                case 'sslcommerz':
                    return $this->sslcommerzRefund($payment, $refundAmount);
                default:
                    throw new \Exception('Unsupported payment gateway for refund');
            }
        } catch (\Exception $e) {
            Log::error('Refund error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get PayPal access token
     */
    private function getPayPalAccessToken(): string
    {
        $response = Http::asForm()->withBasicAuth(
            $this->paypalClientId,
            $this->paypalSecret
        )->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);

        $result = $response->json();
        return $result['access_token'];
    }

    /**
     * Create payment record
     */
    private function createPaymentRecord(array $data): Payment
    {
        return Payment::create($data);
    }

    /**
     * Stripe refund
     */
    private function stripeRefund(Payment $payment, float $amount): array
    {
        $response = Http::withToken($this->stripeSecret)
            ->asForm()
            ->post('https://api.stripe.com/v1/refunds', [
                'payment_intent' => $payment->gateway_transaction_id,
                'amount' => $amount * 100, // Convert to cents
            ]);

        $refund = $response->json();

        if (!$response->successful()) {
            throw new \Exception($refund['error']['message'] ?? 'Stripe refund failed');
        }

        $this->updatePaymentStatus($payment, 'refunded', [
            'refund_id' => $refund['id'],
            'refund_amount' => $amount,
        ]);

        return [
            'success' => true,
            'refund_id' => $refund['id'],
            'amount' => $amount,
        ];
    }

    /**
     * PayPal refund
     */
    private function paypalRefund(Payment $payment, float $amount): array
    {
        $accessToken = $this->getPayPalAccessToken();
        
        $response = Http::withToken($accessToken)
            ->post("https://api-m.sandbox.paypal.com/v2/payments/captures/{$payment->gateway_transaction_id}/refund", [
                'amount' => [
                    'value' => number_format($amount, 2, '.', ''),
                    'currency_code' => $payment->currency,
                ],
            ]);

        $refund = $response->json();

        if (!$response->successful()) {
            throw new \Exception($refund['message'] ?? 'PayPal refund failed');
        }

        $this->updatePaymentStatus($payment, 'refunded', [
            'refund_id' => $refund['id'],
            'refund_amount' => $amount,
        ]);

        return [
            'success' => true,
            'refund_id' => $refund['id'],
            'amount' => $amount,
        ];
    }

    /**
     * SSLCommerz refund
     */
    private function sslcommerzRefund(Payment $payment, float $amount): array
    {
        // SSLCommerz refund implementation
        $response = Http::asForm()->post('https://securepay.sslcommerz.com/validator/api/merchantTransAPI.php', [
            'store_id' => $this->sslCommerzStoreId,
            'store_passwd' => $this->sslCommerzStorePassword,
            'bank_tran_id' => $payment->gateway_response['bank_tran_id'] ?? '',
            'refund_amount' => $amount,
            'refund_remarks' => 'Refund request',
        ]);

        $result = $response->json();

        if ($result['status'] !== 'SUCCESS') {
            throw new \Exception($result['error'] ?? 'SSLCommerz refund failed');
        }

        $this->updatePaymentStatus($payment, 'refunded', [
            'refund_id' => $result['refund_trans_id'],
            'refund_amount' => $amount,
        ]);

        return [
            'success' => true,
            'refund_id' => $result['refund_trans_id'],
            'amount' => $amount,
        ];
    }
}