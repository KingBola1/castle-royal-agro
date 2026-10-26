<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BrevoMailService;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

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

        // Send to System Owner, but set the "Reply-To" to the visitor's email
        BrevoMailService::send(
            env('MAIL_FROM_ADDRESS'), 
            'Castle Royal Admin',
            'New Website Inquiry: ' . $validated['subject'],
            $htmlContent,
            $validated['email'], // $replyToEmail
            $validated['name']   // $replyToName
        );

        return back()->with('success', 'Message Sent! Thank you for contacting Castle Royal Agro. We will reply shortly.');
    }
}