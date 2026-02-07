<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\User;
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

        return back()->with('status', 'Withdrawal request updated successfully.');
    }
}
