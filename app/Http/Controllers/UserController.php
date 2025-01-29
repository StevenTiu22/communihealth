<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function index() : View
    {
        return view('barangay-official.user-accounts');
    }
}
