<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function create()
    {
        return view('withdrawals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_details' => 'required|string',
        ]);

        $user = Auth::user();

        if ($request->amount > $user->projected_roi) {
            return back()->withErrors(['amount' => 'Insufficient funds in Projected ROI balance.']);
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'payment_details' => $request->payment_details,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('status', 'Withdrawal request submitted successfully.');
    }
}
