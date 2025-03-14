<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class HealthRecordController extends Controller
{
    public function index(): View
    {
        return view('health-records.index', ['title' => 'Health Records']);
    }
}
