<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BrevoMailService;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // 1. Ensure the user filled out all fields correctly
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 2. Format the email beautifully
        $htmlContent = "
            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px; max-width: 600px;'>
                <h2 style='color: #2E7D32;'>New Website Inquiry</h2>
                <p><strong>From:</strong> {$validated['name']} ({$validated['email']})</p>
                <p><strong>Subject:</strong> {$validated['subject']}</p>
                <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                <p><strong>Message:</strong></p>
                <p style='background-color: #f9f9f9; padding: 15px; border-radius: 5px;'>" . nl2br(e($validated['message'])) . "</p>
            </div>
        ";

        // 3. Send it to the System Owner via Brevo
        BrevoMailService::send(
            env('MAIL_FROM_ADDRESS'), // This sends it to your admin email defined in .env
            'Castle Royal Admin',
            'New Website Inquiry: ' . $validated['subject'],
            $htmlContent
        );

        // 4. Send the user back to the page with a success message
        return back()->with('success', 'Message Sent! Thank you for contacting Castle Royal Agro. We will reply shortly.');
    }
}