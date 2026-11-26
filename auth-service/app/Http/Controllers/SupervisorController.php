<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    // List all supervisors with the number of students each one supervises
    public function index()
    {
        $supervisors = User::where('role', 'supervisor')
            ->withCount('supervisedPlacements')
            ->orderBy('name')
            ->get();

        return view('supervisors.index', ['supervisors' => $supervisors]);
    }

    // Show the empty "add supervisor" form
    public function create()
    {
        return view('supervisors.create');
    }

    // Validate and create a supervisor account
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // The role is fixed here and never taken from the form
        User::create(array_merge($data, ['role' => 'supervisor']));

        return redirect('/supervisors')->with('success', 'messages.supervisor_created');
    }
}