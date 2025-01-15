<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index(): View
    {
        return view('admin.audit-trail');
    }
}
