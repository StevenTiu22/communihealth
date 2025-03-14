<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MedicineController extends Controller
{
    public function index(): View
    {
        return view('medicines.index', [
            'title' => 'Medicine Inventory',
        ]);
    }
}
