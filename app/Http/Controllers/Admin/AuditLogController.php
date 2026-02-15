<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        // CCTV LOCK: Only System Owners OR Super Admins with explicit 'view_audit_logs' permission
        if (!auth()->user()->hasRole('System Owner') && !auth()->user()->hasPermissionTo('view_audit_logs')) {
            abort(403, 'ACCESS DENIED: You do not have security clearance to view the Global Audit Trail.');
        }

        // Fetch logs with relationships, newest first, 20 per page
        $logs = AuditLog::with(['admin', 'user'])->latest()->paginate(20);
        return view('admin.audit-logs.index', compact('logs'));
    }
}
