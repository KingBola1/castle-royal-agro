<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    /**
     * Send an email via Brevo API (Direct HTTP)
     *
     * @param string $toEmail Recipient Email
     * @param string $toName Recipient Name
     * @param string $subject Email Subject
     * @param string $htmlContent HTML Body
     * @return bool True if successful, False otherwise
     */
    public static function send($toEmail, $toName, $subject, $htmlContent)
    {
        try {
            $response = Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => env('MAIL_FROM_NAME', 'Castle Royal Agro'),
                    'email' => env('MAIL_FROM_ADDRESS')
                ],
                'to' => [
                    [
                        'email' => $toEmail,
                        'name' => $toName
                    ]
                ],
                'subject' => $subject,
                'htmlContent' => $htmlContent
            ]);

            if ($response->successful()) {
                Log::info("Brevo Email Sent to {$toEmail}: {$subject}");
                return true;
            } else {
                Log::error("Brevo API Error (To: {$toEmail}): " . $response->body());
                return false;
            }

        } catch (\Exception $e) {
            Log::error("Brevo API Exception: " . $e->getMessage());
            return false;
        }
    }
}
