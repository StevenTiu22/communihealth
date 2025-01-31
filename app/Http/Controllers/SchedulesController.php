<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SchedulesController extends Controller
{
    public function index(): View
    {
        return view('schedules.index', [
            'title' => 'Schedules'
        ]);
    }
}
