<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Channels\WhatsAppChannel;

class BookingConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
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
        $packageName = $this->booking->travelPackage->title ?? 'Travel Package';
        
        return (new MailMessage)
            ->subject('Booking Confirmation - ' . $this->booking->booking_reference)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your booking has been confirmed successfully!')
            ->line('Booking Reference: ' . $this->booking->booking_reference)
            ->line('Package: ' . $packageName)
            ->line('Number of Travelers: ' . $this->booking->number_of_travelers)
            ->line('Total Amount: $' . number_format($this->booking->total_price, 2))
            ->line('Payment Status: ' . ucfirst($this->booking->status))
            ->action('View Booking Details', route('user.bookings'))
            ->line('Please make payment to secure your booking.')
            ->salutation('Best regards, Travel Business Team');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Booking Confirmation',
            'message' => "Your booking {$this->booking->booking_reference} has been confirmed",
            'booking_id' => $this->booking->id,
            'booking_reference' => $this->booking->booking_reference,
            'amount' => $this->booking->total_price,
            'type' => 'booking',
            'url' => route('user.bookings'),
        ];
    }

    public function toWhatsApp($notifiable)
    {
        $packageName = $this->booking->travelPackage->title ?? 'Travel Package';
        
        $message = "✅ Your booking has been confirmed!\n\n" .
                  "Reference: {$this->booking->booking_reference}\n" .
                  "Package: {$packageName}\n" .
                  "Travelers: {$this->booking->number_of_travelers}\n" .
                  "Amount: \${$this->booking->total_price}\n\n" .
                  "Thank you for choosing Travel Business!";

        return [
            'phone' => $notifiable->phone,
            'message' => $message,
        ];
    }
}