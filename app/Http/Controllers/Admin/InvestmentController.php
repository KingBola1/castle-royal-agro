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
        if ($investment->status !== 'pending') {
            return back()->with('error', 'Investment is already processed.');
        }

        $investment->status = 'active';
        
        // If start_date column exists, set it to now
        if (Schema::hasColumn('investments', 'start_date')) {
            $investment->start_date = now();
        }

        $investment->save();

        return back()->with('success', 'Investment approved successfully.');
    }

    /**
     * Reject the specified investment.
     */
    public function reject(Investment $investment)
    {
        if ($investment->status !== 'pending') {
            return back()->with('error', 'Investment is already processed.');
        }

        $investment->status = 'rejected';
        $investment->save();

        return back()->with('success', 'Investment rejected successfully.');
    }
}
