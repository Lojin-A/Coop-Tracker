<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    // After login every role lands on the placements page, which is filtered by role
    public function index()
    {
        return redirect('/placements');
    }
}