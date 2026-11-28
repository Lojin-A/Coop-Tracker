<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlacementResource;
use App\Models\Company;
use App\Models\Placement;
use Illuminate\Http\Request;

class PlacementApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Placement::with(['student', 'company'])
            ->where('status', 'active');

        if ($user->role === 'supervisor') {
            $query->where('supervisor_id', $user->id);
        } elseif ($user->role === 'student') {
            $query->where('student_id', $user->id);
        }
        return PlacementResource::collection($query->get());
    }

    public function show(Request $request, Placement $placement)
    {
        $user = $request->user();

        $allowed = $user->role === 'coordinator'
            || ($user->role === 'student' && $placement->student_id === $user->id)
            || ($user->role === 'supervisor' && $placement->supervisor_id === $user->id);

        abort_unless($allowed, 403);

        return new PlacementResource($placement->load(['student', 'company']));
    }

    public function bySupervisor(Request $request, $id)
    {
        $user = $request->user();

        abort_unless($user->role === 'coordinator' || $user->id == $id, 403);

        $placements = Placement::with(['student', 'company'])
            ->where('supervisor_id', $id)
            ->get();

        return PlacementResource::collection($placements);
    }

    public function stats(Request $request)
    {
        abort_unless($request->user()->role === 'coordinator', 403);

        return response()->json([
            'active_placements' => Placement::where('status', 'active')->count(),
            'students_per_company' => Company::withCount('placements')
                ->get()
                ->map(fn ($c) => [
                    'company_id'   => $c->id,
                    'company_name' => $c->name,
                    'students'     => $c->placements_count,
                ]),
        ]);
    }
}