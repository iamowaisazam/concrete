<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class FrontendController extends Controller
{
    public function pricing()
    {
        // Fetch all membership plans from the database
        $plans = Plan::all();



        // Pass them to the view
        return view('front.pricing', compact('plans'));
    }
}
