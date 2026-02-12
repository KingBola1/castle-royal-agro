<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->latest()->paginate(10);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $withdrawal->update(['status' => $request->status]);

        // Logic for handling funds/transactions would go here (e.g., deducting balance if approved)
        // For now, we assume simple status tracking.

        return redirect()->route('admin.withdrawals.index')->with('status', 'Withdrawal request updated!');
    }
}
