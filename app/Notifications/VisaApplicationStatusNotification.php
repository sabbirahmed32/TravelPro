<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Channels\WhatsAppChannel;

class VisaApplicationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $visaApplication;
    protected $oldStatus;
    protected $newStatus;

    public function __construct($visaApplication, string $newStatus, string $oldStatus = null)
    {
        $this->visaApplication = $visaApplication;
        $this->newStatus = $newStatus;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable)
    {
        $channels = ['mail', 'database'];
        
        // Add WhatsApp channel if configured and user has opted in
        if (config('services.whatsapp.enabled') && $notifiable->whatsapp_notifications) {
            $channels[] = WhatsAppChannel::class;
        }
        
        return $channels;
    }

    public function toMail($notifiable)
    {
        $subject = match($this->newStatus) {
            'approved' => 'Visa Application Approved! 🎉',
            'rejected' => 'Visa Application Update',
            'under_review' => 'Visa Application Under Review',
            'completed' => 'Visa Application Completed',
            default => 'Visa Application Status Update',
        };

        $message = match($this->newStatus) {
            'approved' => 'Congratulations! Your visa application for ' . $this->visaApplication->destination_country . ' has been approved.',
            'rejected' => 'We regret to inform you that your visa application has been rejected. Please check your application for more details.',
            'under_review' => 'Your visa application is now under review. We will notify you of any updates.',
            'completed' => 'Your visa application has been completed successfully.',
            default => 'Your visa application status has been updated to ' . ucfirst($this->newStatus),
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $this->visaApplication->first_name . '!')
            ->line($message)
            ->line('Application Reference: ' . $this->visaApplication->id)
            ->line('Destination: ' . $this->visaApplication->destination_country)
            ->line('Visa Type: ' . ucfirst($this->visaApplication->visa_type))
            ->action('View Application', route('user.visa-applications'))
            ->line('Thank you for using our visa services!')
            ->salutation('Best regards, Travel Business Team');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Visa Application Status Update',
            'message' => "Your visa application status has been updated to: " . ucfirst($this->newStatus),
            'application_id' => $this->visaApplication->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'type' => 'visa_application',
            'url' => route('user.visa-applications'),
        ];
    }

    public function toWhatsApp($notifiable)
    {
        $message = match($this->newStatus) {
            'approved' => "🎉 Congratulations! Your visa application for {$this->visaApplication->destination_country} has been approved. Reference: {$this->visaApplication->id}",
            'rejected' => "Your visa application has been rejected. Please check your application for more details. Reference: {$this->visaApplication->id}",
            'under_review' => "Your visa application is now under review. We will notify you of updates. Reference: {$this->visaApplication->id}",
            'completed' => "Your visa application has been completed successfully. Reference: {$this->visaApplication->id}",
            default => "Your visa application status has been updated to: " . ucfirst($this->newStatus) . ". Reference: {$this->visaApplication->id}",
        };

        return [
            'phone' => $notifiable->phone,
            'message' => $message,
        ];
    }
}