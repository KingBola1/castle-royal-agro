<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function downloadAuditLogs(Request $request)
    {
        $currentUser = auth()->user();
        
        // Grab all logs from newest to oldest
        $query = AuditLog::with(['admin', 'user'])->latest();

        // --- THE HIERARCHY BLINDFOLD ---
        if ($currentUser->role === 'super_admin') {
            // Super Admins cannot see System Owner actions
            $query->whereHas('admin', function ($q) {
                $q->where('role', '!=', 'System Owner');
            });
        } elseif ($currentUser->role === 'admin') {
            // Regular Admins can ONLY see actions that affect standard investors
            $query->whereHas('user', function ($q) {
                $q->where('role', 'investor');
            });
        }

        $logs = $query->get();

        // --- IF THE USER CLICKED "DOWNLOAD PDF" ---
        if ($request->format === 'pdf') {
            // Send the data to the PDF design template
            $pdf = Pdf::loadView('admin.reports.audit_logs_pdf', compact('logs'));
            return $pdf->download('Castle_Royal_Audit_Logs.pdf');
        }

        // --- IF THE USER CLICKED "DOWNLOAD EXCEL (CSV)" ---
        if ($request->format === 'csv') {
            $response = new StreamedResponse(function() use ($logs) {
                $handle = fopen('php://output', 'w');
                
                // Create the Excel Header Row
                fputcsv($handle, ['Date & Time', 'Admin / Staff', 'Action Taken', 'Affected User', 'Details']);
                
                // Add each log as a new row
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

            // Tell the browser this is a downloadable Excel/CSV file
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="Castle_Royal_Audit_Logs.csv"');
            return $response;
        }
    }
}