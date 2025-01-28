<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function barangayOfficial(): View
    {
        return view('dashboard.barangay-official', [
            'user' => auth()->user()
        ]);
    }

    public function bhw(): View
    {
        return view('dashboard.bhw', [
            'user' => auth()->user()
        ]);
    }

    public function doctor(): View
    {
        return view('dashboard.doctor', [
            'user' => auth()->user()
        ]);
    }
}
