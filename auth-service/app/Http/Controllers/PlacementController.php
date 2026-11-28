<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Placement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PlacementController extends Controller
{
    // List placements, filtered by the logged-in user's role (core of RBAC)
    public function index()
    {
        $user = auth()->user();
        $query = Placement::with(['student', 'supervisor', 'company']);

        if ($user->role === 'supervisor') {
            $query->where('supervisor_id', $user->id);
        }

        if ($user->role === 'student') {
            $query->where('student_id', $user->id);
        }

        return view('placements.index', ['placements' => $query->get()]);
    }

    // Show the empty form; the dropdowns need students, supervisors and companies
    public function create()
    {
        return view('placements.create', $this->formLists());
    }

    // Validate and save a new placement
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'     => ['required', Rule::exists('users', 'id')->where('role', 'student'), 'unique:placements,student_id'],
            'supervisor_id'  => ['required', Rule::exists('users', 'id')->where('role', 'supervisor')],
            'company_id'     => 'required|exists:companies,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after:start_date',
            'required_weeks' => 'required|integer|min:1',
            'status'         => 'required|in:active,completed,cancelled',
        ]);

        Placement::create($data);

        return redirect('/placements')->with('success', 'messages.placement_created');
    }

    // Show one placement; the policy blocks users from viewing other people's records
    public function show(Placement $placement)
    {
        Gate::authorize('view', $placement);

        $placement->load(['student', 'supervisor', 'company']);

        return view('placements.show', ['placement' => $placement]);
    }

    // Show the edit form filled with the placement's data
    public function edit(Placement $placement)
    {
        return view('placements.edit', array_merge(['placement' => $placement], $this->formLists()));
    }

    // Validate and update; a student may keep their own placement but not take another's
    public function update(Request $request, Placement $placement)
    {
        $data = $request->validate([
            'student_id'     => ['required', Rule::exists('users', 'id')->where('role', 'student'), Rule::unique('placements', 'student_id')->ignore($placement->id)],
            'supervisor_id'  => ['required', Rule::exists('users', 'id')->where('role', 'supervisor')],
            'company_id'     => 'required|exists:companies,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after:start_date',
            'required_weeks' => 'required|integer|min:1',
            'status'         => 'required|in:active,completed,cancelled',
        ]);

        $placement->update($data);

        return redirect('/placements')->with('success', 'messages.placement_updated');
    }

    // Delete a placement
    public function destroy(Placement $placement)
    {
        $placement->delete();

        return redirect('/placements')->with('success', 'messages.placement_deleted');
    }

    // Data needed by the create and edit dropdowns
    private function formLists(): array
    {
        return [
            'students'    => User::where('role', 'student')->get(),
            'supervisors' => User::where('role', 'supervisor')->get(),
            'companies'   => Company::all(),
        ];
    }
}