<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DiseaseDemographicsController extends Controller
{
    public function index(): View
    {
        return view('disease-demographics.index', [
            'title' => 'Disease Demographics'
        ]);
    }
}
