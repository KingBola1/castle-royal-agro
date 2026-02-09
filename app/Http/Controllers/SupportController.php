<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BrevoMailService;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    /**
     * Handle the contact support form submission.
     */
    public function handleContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Send email to Admin
            $adminEmail = env('MAIL_FROM_ADDRESS');
            $subject = '📩 New Support Request: ' . $request->subject;
            
            $htmlContent = "
                <div style='font-family: Arial; padding: 20px; border: 1px solid #eee;'>
                    <h2>New Support Message</h2>
                    <p><strong>From:</strong> {$request->name} ({$request->email})</p>
                    <p><strong>Subject:</strong> {$request->subject}</p>
                    <hr>
                    <p><strong>Message:</strong></p>
                    <p>" . nl2br(e($request->message)) . "</p>
                </div>
            ";

            BrevoMailService::send($adminEmail, 'Castle Royal Support', $subject, $htmlContent);

            return redirect()->back()->with('success', 'Your message has been sent to our support team! 🚀');

        } catch (\Exception $e) {
            Log::error('Support Email Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Sorry, something went wrong. Please try again later.');
        }
    }
}
