<?php

namespace App\Http\Controllers;

use App\Models\WeeklyReport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WeeklyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('user.role');

        if ($role === 'student') {
            $reports = WeeklyReport::where('placement_id', session('user.placement_id'));
        } elseif ($role === 'supervisor') {
            $reports = WeeklyReport::whereIn('placement_id', [1, 2, 3, 4, 5, 6]); // temporary until Phase 7
        } else {
            $reports = WeeklyReport::query(); // coordinator sees all
        }

        $reports = $reports->orderBy('week_no', 'desc')->paginate(10);
        return view('reports.index', ['reports' => $reports, 'page' => 'reports']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session('user.role') !== 'student') {
            abort(403, 'Only students can submit reports.');
        }

        $placementId = session('user.placement_id');

        $data = $request->validate([
            'week_no'    => ['required', 'integer', 'min:1',
                            Rule::unique('weekly_reports')->where('placement_id', $placementId)], 
            'content'    => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf|max:5120', 
        ]);

        if ($request->file('attachment')) {
            $data['file_path'] = $request->file('attachment')->store('reports', 'public'); 
        }

        $data['placement_id'] = $placementId;
        $data['status'] = $request->input('action') == 'submit' ? 'submitted' : 'draft';

        WeeklyReport::create($data);
        return redirect('/reports');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $report = WeeklyReport::findOrFail($id);

        if (session('user.role') === 'student'
            && $report->placement_id !== session('user.placement_id')) {
            abort(403);
        }

        return view('reports.show', ['report' => $report, 'page' => 'reports']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WeeklyReport $weeklyReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (session('user.role') !== 'supervisor') {
            abort(403, 'Only supervisors can give feedback.');
        }

        $request->validate([
            'feedback' => 'required|string',
            'decision' => 'required|in:reviewed,changes_requested', // ⚠️ "in" rule outside slides
        ]);

        $report = WeeklyReport::findOrFail($id);
        $report->feedback = $request->input('feedback');
        $report->status   = $request->input('decision'); // reviewed or changes_requested
        $report->save();

        return redirect('/reports/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WeeklyReport $weeklyReport)
    {
        //
    }
}
