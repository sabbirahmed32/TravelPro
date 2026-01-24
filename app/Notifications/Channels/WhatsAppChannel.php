<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsApp($notifiable);
        
        if (!$message || !isset($message['phone']) || !isset($message['message'])) {
            return;
        }

        $this->sendMessage($message['phone'], $message['message']);
    }

    /**
     * Send WhatsApp message
     */
    protected function sendMessage(string $phone, string $message): bool
    {
        try {
            $provider = config('services.whatsapp.provider', 'twilio');
            
            return match($provider) {
                'twilio' => $this->sendViaTwilio($phone, $message),
                'whatsapp_api' => $this->sendViaWhatsAppAPI($phone, $message),
                default => $this->sendViaWhatsAppAPI($phone, $message),
            };
        } catch (\Exception $e) {
            Log::error('WhatsApp message failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send via Twilio WhatsApp API
     */
    protected function sendViaTwilio(string $phone, string $message): bool
    {
        $accountSid = config('services.whatsapp.twilio.account_sid');
        $authToken = config('services.whatsapp.twilio.auth_token');
        $fromNumber = config('services.whatsapp.twilio.from_number');

        $response = Http::asForm()
            ->withBasicAuth($accountSid, $authToken)
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                'From' => "whatsapp:{$fromNumber}",
                'To' => "whatsapp:{$phone}",
                'Body' => $message,
            ]);

        return $response->successful();
    }

    /**
     * Send via WhatsApp Business API
     */
    protected function sendViaWhatsAppAPI(string $phone, string $message): bool
    {
        $accessToken = config('services.whatsapp.access_token');
        $phoneNumberId = config('services.whatsapp.phone_number_id');
        $version = config('services.whatsapp.api_version', 'v16.0');

        $response = Http::withToken($accessToken)
            ->post("https://graph.facebook.com/{$version}/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'text',
                'text' => [
                    'body' => $message,
                ],
            ]);

        return $response->successful();
    }

    /**
     * Send via MessageBird API
     */
    protected function sendViaMessageBird(string $phone, string $message): bool
    {
        $accessKey = config('services.whatsapp.messagebird.access_key');
        $channelId = config('services.whatsapp.messagebird.channel_id');

        $response = Http::withHeaders([
            'Authorization' => 'AccessKey ' . $accessKey,
            'Content-Type' => 'application/json',
        ])->post('https://conversations.messagebird.com/v1/send', [
            'to' => [
                [
                    'type' => 'whatsapp',
                    'identifier' => $phone,
                ],
            ],
            'from' => $channelId,
            'type' => 'text',
            'content' => [
                'text' => $message,
            ],
        ]);

        return $response->successful();
    }

    /**
     * Format phone number for WhatsApp
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add country code if missing (default to US)
        if (strlen($phone) === 10) {
            $phone = '1' . $phone;
        }
        
        return $phone;
    }

    /**
     * Check if WhatsApp service is enabled
     */
    protected function isEnabled(): bool
    {
        return config('services.whatsapp.enabled', false);
    }

    /**
     * Check if user has opted in for WhatsApp notifications
     */
    protected function userHasOptedIn($notifiable): bool
    {
        return $notifiable->whatsapp_notifications ?? false;
    }
}