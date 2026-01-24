<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Channels\WhatsAppChannel;

class PaymentStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payment;
    protected $status;

    public function __construct($payment, string $status)
    {
        $this->payment = $payment;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        $channels = ['mail', 'database'];
        
        if (config('services.whatsapp.enabled') && $notifiable->whatsapp_notifications) {
            $channels[] = WhatsAppChannel::class;
        }
        
        return $channels;
    }

    public function toMail($notifiable)
    {
        $subject = match($this->status) {
            'completed' => 'Payment Completed - Thank You! 💳',
            'failed' => 'Payment Failed',
            'refunded' => 'Payment Refunded',
            'pending' => 'Payment Processing',
            default => 'Payment Status Update',
        };

        $message = match($this->status) {
            'completed' => 'Your payment of $' . number_format($this->payment->amount, 2) . ' has been successfully processed.',
            'failed' => 'Unfortunately, your payment of $' . number_format($this->payment->amount, 2) . ' has failed. Please try again.',
            'refunded' => 'A refund of $' . number_format($this->payment->amount, 2) . ' has been processed for your payment.',
            'pending' => 'Your payment of $' . number_format($this->payment->amount, 2) . ' is being processed.',
            default => 'Your payment status has been updated to: ' . ucfirst($this->status),
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($message)
            ->line('Payment ID: ' . $this->payment->id)
            ->line('Amount: $' . number_format($this->payment->amount, 2))
            ->line('Payment Method: ' . ucfirst($this->payment->gateway))
            ->line('Payment Date: ' . $this->payment->created_at->format('M d, Y H:i'))
            ->action('View Payment History', route('user.payments'))
            ->salutation('Best regards, Travel Business Team');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Payment Status Update',
            'message' => "Your payment status has been updated to: " . ucfirst($this->status),
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount,
            'gateway' => $this->payment->gateway,
            'status' => $this->status,
            'type' => 'payment',
            'url' => route('user.payments'),
        ];
    }

    public function toWhatsApp($notifiable)
    {
        $message = match($this->status) {
            'completed' => "💳 Payment completed! Amount: \${$this->payment->amount}. Thank you for your payment. Reference: {$this->payment->id}",
            'failed' => "❌ Payment failed for \${$this->payment->amount}. Please try again. Reference: {$this->payment->id}",
            'refunded' => "💰 Refund processed for \${$this->payment->amount}. Reference: {$this->payment->id}",
            'pending' => "⏳ Payment of \${$this->payment->amount} is being processed. Reference: {$this->payment->id}",
            default => "Payment status updated to: " . ucfirst($this->status) . ". Amount: \${$this->payment->amount}. Reference: {$this->payment->id}",
        };

        return [
            'phone' => $notifiable->phone,
            'message' => $message,
        ];
    }
}