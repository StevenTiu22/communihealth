<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(): View
    {
        return view('patients.index', [
            'title' => 'Patient Records'
        ]);
    }
}
