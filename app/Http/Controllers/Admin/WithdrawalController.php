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
    public function approve($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $withdrawal->update(['status' => 'approved']);

        // Send Email
        \Illuminate\Support\Facades\Mail::to($withdrawal->user->email)->send(new \App\Mail\WithdrawalApproved($withdrawal));

        return redirect()->back()->with('status', 'Withdrawal approved and investor notified!');
    }

    public function reject($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $withdrawal->update(['status' => 'rejected']);

        // Send Email
        \Illuminate\Support\Facades\Mail::to($withdrawal->user->email)->send(new \App\Mail\WithdrawalRejected($withdrawal));

        return redirect()->back()->with('status', 'Withdrawal rejected and investor notified!');
    }
}
