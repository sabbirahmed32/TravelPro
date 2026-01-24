<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\VisaApplication;
use App\Models\StudentApplication;
use App\Models\Consultation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
        $this->middleware('auth');
    }

    /**
     * Show payment page for a payable item
     */
    public function checkout(Request $request): View
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $gateway = $request->input('gateway', 'stripe');

        $payable = $this->getPayable($type, $id);
        
        if (!$payable) {
            abort(404, 'Payable item not found');
        }

        // Calculate amount
        $amount = $this->calculateAmount($payable, $type);

        return view('payment.checkout', compact('payable', 'type', 'id', 'amount', 'gateway'));
    }

    /**
     * Process payment
     */
    public function process(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:visa,student,booking,consultation',
            'id' => 'required|integer',
            'gateway' => 'required|in:stripe,paypal,sslcommerz',
            'payment_method_id' => 'required_if:gateway,stripe',
            'customer_email' => 'required|email',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'customer_city' => 'nullable|string|max:100',
            'customer_country' => 'nullable|string|max:100',
        ]);

        $payable = $this->getPayable($request->type, $request->id);
        
        if (!$payable) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        $amount = $this->calculateAmount($payable, $request->type);

        $paymentData = [
            'user_id' => $request->user()->id,
            'type' => $request->type,
            'payable_id' => $request->id,
            'payable_type' => $this->getPayableType($request->type),
            'amount' => $amount,
            'currency' => 'USD', // Can be made dynamic
            'customer_email' => $request->customer_email,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_city' => $request->customer_city,
            'customer_country' => $request->customer_country,
            'payment_method_id' => $request->payment_method_id ?? null,
            'description' => "Payment for {$request->type} #{$request->id}",
        ];

        $result = match($request->gateway) {
            'stripe' => $this->paymentService->createStripePayment($paymentData),
            'paypal' => $this->paymentService->createPayPalPayment($paymentData),
            'sslcommerz' => $this->paymentService->createSSLCommerzPayment($paymentData),
            default => ['success' => false, 'message' => 'Invalid payment gateway'],
        };

        return response()->json($result);
    }

    /**
     * SSLCommerz success callback
     */
    public function sslcommerzSuccess(Request $request): View
    {
        $valId = $request->input('val_id');
        $transactionId = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        if (!$this->paymentService->verifySSLCommerzPayment($request->all())) {
            return view('payment.failed', ['message' => 'Payment verification failed']);
        }

        $payment = Payment::where('gateway_transaction_id', $transactionId)->first();
        if ($payment) {
            $this->paymentService->updatePaymentStatus($payment, 'completed', $request->all());
            $this->updatePayableStatus($payment);
        }

        return view('payment.success', compact('payment'));
    }

    /**
     * SSLCommerz fail callback
     */
    public function sslcommerzFail(Request $request): View
    {
        $transactionId = $request->input('tran_id');
        $payment = Payment::where('gateway_transaction_id', $transactionId)->first();
        
        if ($payment) {
            $this->paymentService->handleFailedPayment($payment, $request->input('error', 'Payment failed'));
        }

        return view('payment.failed', ['message' => $request->input('error', 'Payment failed')]);
    }

    /**
     * SSLCommerz cancel callback
     */
    public function sslcommerzCancel(Request $request): RedirectResponse
    {
        $transactionId = $request->input('tran_id');
        $payment = Payment::where('gateway_transaction_id', $transactionId)->first();
        
        if ($payment) {
            $this->paymentService->handleFailedPayment($payment, 'Payment cancelled by user');
        }

        return redirect()->route('dashboard.user')
            ->with('error', 'Payment was cancelled');
    }

    /**
     * SSLCommerz IPN (Instant Payment Notification)
     */
    public function sslcommerzIPN(Request $request): JsonResponse
    {
        try {
            $transactionId = $request->input('tran_id');
            $payment = Payment::where('gateway_transaction_id', $transactionId)->first();

            if (!$payment) {
                return response()->json(['status' => 'error', 'message' => 'Payment not found']);
            }

            if ($this->paymentService->verifySSLCommerzPayment($request->all())) {
                $this->paymentService->updatePaymentStatus($payment, 'completed', $request->all());
                $this->updatePayableStatus($payment);
                
                return response()->json(['status' => 'success']);
            } else {
                $this->paymentService->handleFailedPayment($payment, 'Verification failed');
                return response()->json(['status' => 'error', 'message' => 'Verification failed']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * PayPal success callback
     */
    public function paypalSuccess(Request $request): View
    {
        $orderId = $request->input('token');
        $payerId = $request->input('PayerID');

        $payment = Payment::where('gateway_transaction_id', $orderId)->first();
        if (!$payment) {
            return view('payment.failed', ['message' => 'Payment not found']);
        }

        $result = $this->paymentService->capturePayPalPayment($orderId);

        if ($result['success'] && $result['status'] === 'COMPLETED') {
            $this->paymentService->updatePaymentStatus($payment, 'completed', $result);
            $this->updatePayableStatus($payment);
            return view('payment.success', compact('payment'));
        } else {
            $this->paymentService->handleFailedPayment($payment, $result['message'] ?? 'PayPal capture failed');
            return view('payment.failed', ['message' => $result['message'] ?? 'Payment failed']);
        }
    }

    /**
     * PayPal cancel callback
     */
    public function paypalCancel(Request $request): RedirectResponse
    {
        $orderId = $request->input('token');
        $payment = Payment::where('gateway_transaction_id', $orderId)->first();
        
        if ($payment) {
            $this->paymentService->handleFailedPayment($payment, 'Payment cancelled by user');
        }

        return redirect()->route('dashboard.user')
            ->with('error', 'Payment was cancelled');
    }

    /**
     * Refund payment
     */
    public function refund(Request $request, Payment $payment): JsonResponse
    {
        $this->authorize('refund', $payment);

        $request->validate([
            'amount' => 'nullable|numeric|min:0.01|max:' . $payment->amount,
            'reason' => 'required|string|max:500',
        ]);

        $refundAmount = $request->input('amount', $payment->amount);
        $result = $this->paymentService->processRefund($payment, $refundAmount);

        if ($result['success']) {
            // Create refund transaction record
            Transaction::create([
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
                'amount' => -$refundAmount, // Negative for refunds
                'currency' => $payment->currency,
                'gateway' => $payment->gateway,
                'gateway_transaction_id' => $result['refund_id'],
                'type' => 'refund',
                'status' => 'completed',
                'description' => $request->reason,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully',
                'refund_id' => $result['refund_id'],
                'amount' => $refundAmount,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 400);
        }
    }

    /**
     * Get payment history
     */
    public function history(Request $request): View
    {
        $payments = $request->user()
            ->payments()
            ->with(['payable'])
            ->latest()
            ->paginate(10);

        return view('payment.history', compact('payments'));
    }

    /**
     * Get payment details
     */
    public function show(Payment $payment): View
    {
        $this->authorize('view', $payment);
        
        $payment->load(['user', 'transactions', 'payable']);
        
        return view('payment.show', compact('payment'));
    }

    /**
     * Get payable instance
     */
    private function getPayable(string $type, int $id)
    {
        return match($type) {
            'visa' => VisaApplication::find($id),
            'student' => StudentApplication::find($id),
            'booking' => Booking::find($id),
            'consultation' => Consultation::find($id),
            default => null,
        };
    }

    /**
     * Get payable model class
     */
    private function getPayableType(string $type): string
    {
        return match($type) {
            'visa' => VisaApplication::class,
            'student' => StudentApplication::class,
            'booking' => Booking::class,
            'consultation' => Consultation::class,
            default => '',
        };
    }

    /**
     * Calculate payment amount
     */
    private function calculateAmount($payable, string $type): float
    {
        return match($type) {
            'visa' => $payable->fee,
            'student' => $payable->service_fee,
            'booking' => $payable->total_price,
            'consultation' => $payable->fee,
            default => 0,
        };
    }

    /**
     * Update payable status after successful payment
     */
    private function updatePayableStatus(Payment $payment): void
    {
        $payable = $payment->payable;
        
        if ($payable) {
            switch ($payment->payable_type) {
                case VisaApplication::class:
                case StudentApplication::class:
                    $payable->update(['payment_status' => 'paid']);
                    break;
                case Booking::class:
                    $currentPaid = $payable->paid_amount + $payment->amount;
                    $payable->update([
                        'paid_amount' => $currentPaid,
                        'payment_status' => $currentPaid >= $payable->total_price ? 'paid' : 'partial',
                    ]);
                    break;
                case Consultation::class:
                    $payable->update(['payment_status' => 'paid']);
                    break;
            }
        }
    }
}