<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SchedulesController extends Controller
{
    public function index(): View
    {
        try {
            // Your original code
            return view('schedules.index', [
                'title' => 'Schedules'
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Schedule index error: ' . $e->getMessage());
            // Return a fallback view or message
            return view('errors.custom')->with('message', 'The schedules page is currently unavailable.');
        }
    }
}
