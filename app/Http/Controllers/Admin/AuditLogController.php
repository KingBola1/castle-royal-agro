<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        // Fetch logs with relationships, newest first, 20 per page
        $logs = AuditLog::with(['admin', 'user'])->latest()->paginate(20);
        return view('admin.audit-logs.index', compact('logs'));
    }
}
