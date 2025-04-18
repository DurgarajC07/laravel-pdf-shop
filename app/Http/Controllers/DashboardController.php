<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $purchases = auth()->user()->purchases()->with('product')->get();
        return view('dashboard', compact('purchases'));
    }
}