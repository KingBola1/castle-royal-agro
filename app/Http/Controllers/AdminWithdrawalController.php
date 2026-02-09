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
            // Send Approval Email via Direct API
            Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => ['email' => env('MAIL_FROM_ADDRESS'), 'name' => 'Castle Royal Admin'],
                'to' => [['email' => $withdrawal->user->email, 'name' => $withdrawal->user->name]],
                'subject' => '🎉 Withdrawal Approved!',
                'htmlContent' => "<h2>Hello {$withdrawal->user->name},</h2><p>Your withdrawal of <strong>GHS " . number_format($withdrawal->amount, 2) . "</strong> has been approved and processed.</p><p>Thank you for investing with Castle Royal Agro.</p>"
            ]);

            return redirect()->back()->with('success', 'Withdrawal Approved & Investor Notified.');
        } 
        elseif ($request->status === 'rejected') {
            // Send Denial Email via Direct API
            Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => ['email' => env('MAIL_FROM_ADDRESS'), 'name' => 'Castle Royal Admin'],
                'to' => [['email' => $withdrawal->user->email, 'name' => $withdrawal->user->name]],
                'subject' => '⚠️ Withdrawal Request Declined',
                'htmlContent' => "<h2>Hello {$withdrawal->user->name},</h2><p>Your withdrawal request for <strong>GHS " . number_format($withdrawal->amount, 2) . "</strong> has been declined.</p><p>Please check your payment details in your dashboard or contact support for more information.</p>"
            ]);

            return redirect()->back()->with('success', 'Withdrawal Denied & Investor Notified.');
        }

        return back()->with('status', 'Withdrawal request updated successfully.');
    }
}
