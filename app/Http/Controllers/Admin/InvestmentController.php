<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $investments = Investment::with(['user', 'package'])->latest()->paginate(10);
        return view('admin.investments.index', compact('investments'));
    }

    /**
     * Approve the specified investment.
     */
    public function approve(Investment $investment)
    {
        if (!auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin']) && !auth()->user()->hasDirectPermission('manage_investments')) {
            abort(403, 'Unauthorized. You do not have the required permissions to manage investments.');
        }

        if ($investment->status !== 'pending') {
            return back()->with('error', 'Investment is already processed.');
        }

        $investment->status = 'active';
        
        // If start_date column exists, set it to now
        if (Schema::hasColumn('investments', 'start_date')) {
            $investment->start_date = now();
        }


        $investment->save();

        // Notify Investor
        try {
            \Illuminate\Support\Facades\Mail::to($investment->user->email)->send(new \App\Mail\InvestmentApproved($investment));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send investment approval email: ' . $e->getMessage());
        }

        // Non-Repudiation Logging (Investment Approved)
        \App\Models\AuditLog::create([
            'user_id' => $investment->user_id,
            'admin_id' => auth()->id(),
            'action' => 'Investment Approved',
            'details' => "Approved investment of GH₵ " . number_format($investment->amount, 2) . " for " . $investment->user->email,
        ]);

        return back()->with('success', 'Investment approved successfully.');
    }

    /**
     * Reject the specified investment.
     */
    public function reject(Investment $investment)
    {
        if (!auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin']) && !auth()->user()->hasDirectPermission('manage_investments')) {
            abort(403, 'Unauthorized. You do not have the required permissions to manage investments.');
        }

        if ($investment->status !== 'pending') {
            return back()->with('error', 'Investment is already processed.');
        }

        $investment->status = 'rejected';
        $investment->save();

        // Non-Repudiation Logging (Investment Rejected)
        \App\Models\AuditLog::create([
            'user_id' => $investment->user_id,
            'admin_id' => auth()->id(),
            'action' => 'Investment Rejected',
            'details' => "Rejected investment of GH₵ " . number_format($investment->amount, 2) . ".",
        ]);

        return back()->with('success', 'Investment rejected successfully.');
    }
}
