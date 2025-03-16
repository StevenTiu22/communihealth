<?php

namespace App\Http\Controllers;

class TBPredictionController extends Controller
{
    public function index()
    {
        return view('tb-prediction.index', ['title' => 'TB Prediction']);
    }
}
