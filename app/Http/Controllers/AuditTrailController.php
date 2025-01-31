<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditTrailController extends Controller
{
    public function index(): View
    {
        return view('barangay-official.audit-trail', ['title' => 'Audit Trail']);
    }
}
