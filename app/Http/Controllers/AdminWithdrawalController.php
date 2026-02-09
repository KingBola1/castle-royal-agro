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

            // 2. Send via Brevo API (Direct HTTP Request)
            $response = Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => env('MAIL_FROM_NAME', 'Castle Royal Admin'),
                    'email' => env('MAIL_FROM_ADDRESS') // FIX: Use verified sender from ENV
                ],
                'to' => [
                    [
                        'email' => $withdrawal->user->email,
                        'name' => $withdrawal->user->name
                    ]
                ],
                'subject' => '🎉 Withdrawal Approved - Castle Royal Agro',
                'htmlContent' => $htmlContent
            ]);

            // 4. Check & Debug
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Withdrawal Approved & Email Sent Successfully! 🚀');
            } else {
                // STOP AND SHOW THE ERROR
                dd('BREVO API ERROR:', $response->body());
            }
        }

        return back()->with('status', 'Withdrawal request updated successfully.');
    }
}
