<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session('user.role') === 'student') {
            $placementIds = [session('user.placement_id')];
        } else {
            $placementIds = [1, 2, 3, 4, 5, 6]; // temporary until Phase 7
        }

        $evaluations = Evaluation::whereIn('placement_id', $placementIds)->get()->keyBy('placement_id');

        return view('evaluations.index', [
            'placementIds' => $placementIds,
            'evaluations'  => $evaluations,
            'page'         => 'evaluations',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($placement)
    {
        if (session('user.role') !== 'supervisor') {
            abort(403, 'Only supervisors can manage evaluations.');
        }

        return view('evaluations.form', [
            'placementId' => $placement,
            'evaluation'  => null,   // null = new evaluation
            'page'        => 'evaluations',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session('user.role') !== 'supervisor') {
            abort(403, 'Only supervisors can manage evaluations.');
        }

        $data = $request->validate([
            'placement_id'     => 'required|integer|unique:evaluations,placement_id', // one evaluation per placement
            'technical_skills' => 'required|integer|min:1|max:5',
            'teamwork'         => 'required|integer|min:1|max:5',
            'communication'    => 'required|integer|min:1|max:5',
            'punctuality'      => 'required|integer|min:1|max:5',
            'initiative'       => 'required|integer|min:1|max:5',
            'comments'         => 'nullable|string',
        ]);

        $data['total'] = $data['technical_skills'] + $data['teamwork'] + $data['communication']
                    + $data['punctuality'] + $data['initiative'];
        $data['status'] = $request->input('action') == 'submit' ? 'submitted' : 'draft';

        Evaluation::create($data);
        return redirect('/evaluations');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        if (session('user.role') === 'student') {
            if ($evaluation->placement_id !== session('user.placement_id')
                || $evaluation->status !== 'submitted') {
                abort(403);
            }
        }

        return view('evaluations.show', ['evaluation' => $evaluation, 'page' => 'evaluations']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (session('user.role') !== 'supervisor') {
            abort(403, 'Only supervisors can manage evaluations.');
        }

        $evaluation = Evaluation::findOrFail($id);
        if ($evaluation->status == 'submitted') abort(403); // locked after submission

        return view('evaluations.form', [
            'placementId' => $evaluation->placement_id,
            'evaluation'  => $evaluation,   // not null = edit mode
            'page'        => 'evaluations',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (session('user.role') !== 'supervisor') {
            abort(403, 'Only supervisors can manage evaluations.');
        }

        $evaluation = Evaluation::findOrFail($id);
        if ($evaluation->status == 'submitted') abort(403); // locked after submission

        $data = $request->validate([
            'technical_skills' => 'required|integer|min:1|max:5',
            'teamwork'         => 'required|integer|min:1|max:5',
            'communication'    => 'required|integer|min:1|max:5',
            'punctuality'      => 'required|integer|min:1|max:5',
            'initiative'       => 'required|integer|min:1|max:5',
            'comments'         => 'nullable|string',
        ]);

        $data['total'] = $data['technical_skills'] + $data['teamwork'] + $data['communication']
                    + $data['punctuality'] + $data['initiative'];
        $data['status'] = $request->input('action') == 'submit' ? 'submitted' : 'draft';

        $evaluation->update($data);
        return redirect('/evaluations/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        //
    }
}
