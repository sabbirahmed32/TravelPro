<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Channels\WhatsAppChannel;

class StudentApplicationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $studentApplication;
    protected $oldStatus;
    protected $newStatus;

    public function __construct($studentApplication, string $newStatus, string $oldStatus = null)
    {
        $this->studentApplication = $studentApplication;
        $this->newStatus = $newStatus;
        $this->oldStatus = $oldStatus;
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
        $subject = match($this->newStatus) {
            'approved' => 'Student Application Approved! 🎓',
            'rejected' => 'Student Application Update',
            'under_review' => 'Student Application Under Review',
            'completed' => 'Student Application Completed',
            default => 'Student Application Status Update',
        };

        $message = match($this->newStatus) {
            'approved' => 'Congratulations! Your student application for ' . $this->studentApplication->desired_course . ' at ' . $this->studentApplication->desired_university . ' has been approved.',
            'rejected' => 'We regret to inform you that your student application has been rejected. Please check your application for more details.',
            'under_review' => 'Your student application is now under review. We will notify you of any updates.',
            'completed' => 'Your student application has been completed successfully.',
            default => 'Your student application status has been updated to ' . ucfirst($this->newStatus),
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $this->studentApplication->first_name . '!')
            ->line($message)
            ->line('Application Reference: ' . $this->studentApplication->id)
            ->line('Desired Course: ' . $this->studentApplication->desired_course)
            ->line('University: ' . $this->studentApplication->desired_university)
            ->line('Target Country: ' . $this->studentApplication->target_country)
            ->action('View Application', route('user.student-applications'))
            ->line('Thank you for using our student admission services!')
            ->salutation('Best regards, Travel Business Team');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Student Application Status Update',
            'message' => "Your student application status has been updated to: " . ucfirst($this->newStatus),
            'application_id' => $this->studentApplication->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'type' => 'student_application',
            'url' => route('user.student-applications'),
        ];
    }

    public function toWhatsApp($notifiable)
    {
        $message = match($this->newStatus) {
            'approved' => "🎓 Congratulations! Your student application for {$this->studentApplication->desired_course} has been approved. Reference: {$this->studentApplication->id}",
            'rejected' => "Your student application has been rejected. Please check your application for more details. Reference: {$this->studentApplication->id}",
            'under_review' => "Your student application is now under review. We will notify you of updates. Reference: {$this->studentApplication->id}",
            'completed' => "Your student application has been completed successfully. Reference: {$this->studentApplication->id}",
            default => "Your student application status has been updated to: " . ucfirst($this->newStatus) . ". Reference: {$this->studentApplication->id}",
        };

        return [
            'phone' => $notifiable->phone,
            'message' => $message,
        ];
    }
}