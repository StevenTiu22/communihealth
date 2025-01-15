<?php

namespace App\Http\Controllers;

class MedicineController extends Controller
{
    public function index()
    {
        return view('core.medicine-inventory');
    }
}
