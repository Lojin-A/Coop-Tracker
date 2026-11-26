<?php

namespace App\Http\Controllers;

use App\Models\User;

class StudentController extends Controller
{
    // List all students with their placement, company and supervisor
    public function index()
    {
        $students = User::where('role', 'student')
            ->with(['placement.company', 'placement.supervisor'])
            ->orderBy('name')
            ->get();

        return view('students.index', ['students' => $students]);
    }
}