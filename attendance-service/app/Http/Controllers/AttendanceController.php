<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // POST /api/check-in
    public function checkIn(Request $request)
    {
        $data = $request->validate([
            'placement_id' => 'required|integer',
        ]);

        $today = now()->toDateString();

        $existing = Attendance::where('placement_id', $data['placement_id'])
            ->where('date', $today)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already checked in today'], 422);
        }

        $attendance = Attendance::create([
            'placement_id' => $data['placement_id'],
            'date' => $today,
            'check_in' => now()->format('H:i:s'),
            'status' => 'pending',
        ]);

        return response()->json($attendance, 201);
    }

    // POST /api/check-out
    public function checkOut(Request $request)
    {
        $data = $request->validate([
            'placement_id' => 'required|integer',
        ]);

        $today = now()->toDateString();

        $attendance = Attendance::where('placement_id', $data['placement_id'])
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'No check-in found for today'], 404);
        }

        if ($attendance->check_out) {
            return response()->json(['message' => 'Already checked out today'], 422);
        }

        $checkOutTime = now()->format('H:i:s');
        $checkIn = Carbon::parse($attendance->date . ' ' . $attendance->check_in);
        $checkOut = Carbon::parse($attendance->date . ' ' . $checkOutTime);

        $attendance->check_out = $checkOutTime;
        $attendance->hours = round($checkIn->diffInMinutes($checkOut) / 60, 2);
        $attendance->save();

        return response()->json($attendance, 200);
    }

    // GET /api/attendance
    public function myAttendance(Request $request)
    {
        $data = $request->validate([
            'placement_id' => 'required|integer',
        ]);

        $records = Attendance::where('placement_id', $data['placement_id'])
            ->orderByDesc('date')
            ->get();

        return response()->json($records, 200);
    }

    // GET /api/placements/{id}/attendance
    public function forPlacement($id)
    {
        $records = Attendance::where('placement_id', $id)
            ->orderByDesc('date')
            ->get();

        return response()->json($records, 200);
    }

    // PUT /api/attendance/{id}
    public function updateStatus(Request $request, $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found'], 404);
        }

        $data = $request->validate([
            'status' => 'required|in:approved,absent',
        ]);

        $attendance->status = $data['status'];
        $attendance->save();

        return response()->json($attendance, 200);
    }

    // GET /api/placements/{id}/hours
    public function hoursForPlacement($id)
    {
        $approvedHours = Attendance::where('placement_id', $id)
            ->where('status', 'approved')
            ->sum('hours');

        $approvedDays = Attendance::where('placement_id', $id)
            ->where('status', 'approved')
            ->count();

        $absentDays = Attendance::where('placement_id', $id)
            ->where('status', 'absent')
            ->count();

        return response()->json([
            'placement_id' => (int) $id,
            'approved_hours' => $approvedHours,
            'approved_days' => $approvedDays,
            'absent_days' => $absentDays,
        ], 200);
    }

    // Web page: supervisor's approval list.
    // TEMPORARY: shows ALL records, not just "my students" — once Jana's
    // auth/me endpoint exists, this should filter to this supervisor's placements.
    public function supervisorView(Request $request)
    {
        app()->setLocale(session('locale', 'en'));

        $activeStatus = $request->query('status', 'pending');
        if (!in_array($activeStatus, ['pending', 'approved', 'absent'])) {
            $activeStatus = 'pending';
        }

        $attendances = Attendance::where('status', $activeStatus)
            ->orderByDesc('date')
            ->get();

        return view('attendance.supervisor', [
            'pendingCount' => Attendance::where('status', 'pending')->count(),
            'approvedCount' => Attendance::where('status', 'approved')->count(),
            'absentCount' => Attendance::where('status', 'absent')->count(),
            'attendances' => $attendances,
            'activeStatus' => $activeStatus,
            'editId' => $request->query('edit'),
        ]);
    }

    // Web form: supervisor approves, marks absent, or edits a previous decision.
    public function webUpdateStatus(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:approved,absent',
        ]);

        $attendance->status = $data['status'];
        $attendance->save();

        return redirect()->back();
    }

    // Web form: student submits or edits an excuse for an absent day, with an
    // optional supporting file (e.g. a sick-leave note). Works for any past or
    // current day, as long as that day is still marked absent.
    public function submitExcuse(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($attendance->status !== 'absent') {
            return redirect()->back();
        }

        $data = $request->validate([
            'excuse' => 'required|string|max:1000',
            'excuse_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $attendance->excuse = $data['excuse'];

        if ($request->hasFile('excuse_file')) {
            $attendance->excuse_file = $request->file('excuse_file')->store('excuses', 'public');
        }

        $attendance->save();

        // Redirect to the plain student page (no "edit_excuse" in the URL),
        // so the inline edit form closes instead of reopening itself.
        return redirect('/attendance/student?placement_id=' . $attendance->placement_id)
            ->with('excuse_submitted', true);
    }

    // Web page: a student's own attendance.
    // TEMPORARY: takes placement_id from the URL query string for now —
    // once auth exists, this should come from the logged-in student's token instead.
    public function studentView(Request $request)
    {
        app()->setLocale(session('locale', 'en'));

        $placementId = $request->query('placement_id', 1);

        $attendances = Attendance::where('placement_id', $placementId)
            ->orderByDesc('date')
            ->get();

        $today = Attendance::where('placement_id', $placementId)
            ->where('date', now()->toDateString())
            ->first();

        return view('attendance.student', [
            'approvedDays' => Attendance::where('placement_id', $placementId)->where('status', 'approved')->count(),
            'pendingCount' => Attendance::where('placement_id', $placementId)->where('status', 'pending')->count(),
            'attendances' => $attendances,
            'today' => $today,
            'placementId' => $placementId,
            'editExcuseId' => $request->query('edit_excuse'),
        ]);
    }

    // GET /api/stats/attendance
    public function stats()
    {
        $pendingCount = Attendance::where('status', 'pending')->count();

        $hoursThisWeek = Attendance::where('status', 'approved')
            ->whereBetween('date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])
            ->sum('hours');

        return response()->json([
            'pending_count' => $pendingCount,
            'hours_this_week' => $hoursThisWeek,
        ], 200);
    }
}
