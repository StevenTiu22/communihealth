<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function barangayOfficial(): View
    {
        if (!Gate::allows('barangay-official'))
            abort(403, 'You are not authorized to access this page.');

        return view('dashboard.barangay-official', [
            'user' => auth()->user()
        ]);
    }

    public function bhw(): View
    {
        if (!Gate::allows('bhw'))
            abort(403, 'You are not authorized to access this page.');

        return view('dashboard.bhw', [
            'user' => auth()->user()
        ]);
    }

    public function doctor(): View
    {
        if (!Gate::allows('doctor'))
            abort(403, 'You are not authorized to access this page.');

        return view('dashboard.doctor', [
            'user' => auth()->user()
        ]);
    }
}
