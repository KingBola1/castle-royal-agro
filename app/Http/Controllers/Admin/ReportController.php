<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Investment;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    // --- 1. AUDIT LOGS REPORT ---
    public function downloadAuditLogs(Request $request)
    {
        $currentUser = auth()->user();
        $query = AuditLog::with(['admin', 'user'])->latest();

        if ($currentUser->role === 'super_admin') {
            $query->whereHas('admin', function ($q) { $q->where('role', '!=', 'System Owner'); });
        } elseif ($currentUser->role === 'admin') {
            $query->whereHas('user', function ($q) { $q->where('role', 'investor'); });
        }

        $logs = $query->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('admin.reports.audit_logs_pdf', compact('logs'));
            return $pdf->download('Castle_Royal_Audit_Logs.pdf');
        }

        if ($request->format === 'csv') {
            $response = new StreamedResponse(function() use ($logs) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Date & Time', 'Admin / Staff', 'Action Taken', 'Affected User', 'Details']);
                foreach ($logs as $log) {
                    fputcsv($handle, [
                        $log->created_at->format('M d, Y h:i A'),
                        $log->admin ? $log->admin->name : 'System',
                        $log->action,
                        $log->user ? $log->user->name : 'N/A',
                        $log->details
                    ]);
                }
                fclose($handle);
            });
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="Castle_Royal_Audit_Logs.csv"');
            return $response;
        }
    }

    // --- 2. INVESTMENTS REPORT ---
    public function downloadInvestments(Request $request)
    {
        // No blindfold needed here: Investments are always attached to standard Investors
        $investments = Investment::with(['user', 'package'])->latest()->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('admin.reports.investments_pdf', compact('investments'));
            return $pdf->download('Castle_Royal_Investments.pdf');
        }

        if ($request->format === 'csv') {
            $response = new StreamedResponse(function() use ($investments) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Date', 'Investor Name', 'Email', 'Package', 'Units', 'Amount Invested (GHS)', 'Expected ROI (GHS)', 'Status']);
                foreach ($investments as $inv) {
                    fputcsv($handle, [
                        $inv->created_at->format('M d, Y'),
                        $inv->user->name ?? 'N/A',
                        $inv->user->email ?? 'N/A',
                        $inv->package->name ?? 'Manual Entry',
                        $inv->units,
                        $inv->amount_invested,
                        $inv->expected_roi,
                        ucfirst($inv->status)
                    ]);
                }
                fclose($handle);
            });
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="Castle_Royal_Investments.csv"');
            return $response;
        }
    }

    // --- 3. WITHDRAWALS REPORT ---
    public function downloadWithdrawals(Request $request)
    {
        $withdrawals = Withdrawal::with('user')->latest()->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('admin.reports.withdrawals_pdf', compact('withdrawals'));
            return $pdf->download('Castle_Royal_Withdrawals.pdf');
        }

        if ($request->format === 'csv') {
            $response = new StreamedResponse(function() use ($withdrawals) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Date Request', 'Investor Name', 'Email', 'Amount (GHS)', 'Payment Details', 'Status']);
                foreach ($withdrawals as $withdrawal) {
                    fputcsv($handle, [
                        $withdrawal->created_at->format('M d, Y H:i'),
                        $withdrawal->user->name ?? 'N/A',
                        $withdrawal->user->email ?? 'N/A',
                        $withdrawal->amount,
                        $withdrawal->payment_details,
                        ucfirst($withdrawal->status)
                    ]);
                }
                fclose($handle);
            });
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="Castle_Royal_Withdrawals.csv"');
            return $response;
        }
    }
}