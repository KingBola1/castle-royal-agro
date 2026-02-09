<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\User;
use App\Mail\WithdrawalApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AdminWithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->latest()->get();
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        if ($request->status === 'approved') {
            // Check balance again just in case
            if ($withdrawal->user->projected_roi < $withdrawal->amount) {
                return back()->with('error', 'User has insufficient funds to approve this withdrawal.');
            }

            // Deduct from User's Projected ROI
            $withdrawal->user->decrement('projected_roi', $withdrawal->amount);
        }

        $withdrawal->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note, // Optional note
        ]);

        if ($request->status === 'approved') {
            // 1. Render the HTML content from the Blade view
            $htmlContent = view('emails.withdrawals.approved', [
                'withdrawal' => $withdrawal, 
                'user' => $withdrawal->user
            ])->render();

            // 2. The Direct API Postman (Bypass Laravel Mail)
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
                        'email' => $withdrawal->user->email,
                        'name' => $withdrawal->user->name
                    ]
                ],
                'subject' => '🎉 Your Withdrawal has been Approved!',
                'htmlContent' => "
                    <div style='font-family: Arial; padding: 20px; border: 1px solid #eee;'>
                        <h2>Hello {$withdrawal->user->name},</h2>
                        <p>Your withdrawal request for <strong>GHS " . number_format($withdrawal->amount, 2) . "</strong> has been approved and processed.</p>
                        <p><strong>Payment Details:</strong> {$withdrawal->payment_details}</p>
                        <hr>
                        <p>Thank you for your continued trust in Castle Royal Agro.</p>
                    </div>"
            ]);

            // 3. Result Handling
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Withdrawal Approved & Notification Sent! 🚀');
            } else {
                Log::error('Brevo API Failure: ' . $response->body());
                return redirect()->back()->with('success', 'Approved, but email notification failed. Check logs.');
            }
        }

        return back()->with('status', 'Withdrawal request updated successfully.');
    }
}
