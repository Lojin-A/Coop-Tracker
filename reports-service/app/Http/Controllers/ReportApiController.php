<?php

namespace App\Http\Controllers;

use App\Models\WeeklyReport;
use App\Http\Resources\WeeklyReportResource;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportApiController extends Controller
{
    // GET /api/reports  or  /api/reports?status=submitted
    public function index(Request $request)
    {
        $query = WeeklyReport::orderBy('updated_at', 'desc');

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        return WeeklyReportResource::collection($query->get());
    }

    // GET /api/reports/late
    // Temporary rule (to agree with Shahad): still draft or changes_requested
    // and not touched for more than 7 days
    public function late()
    {
        $reports = WeeklyReport::whereIn('status', ['draft', 'changes_requested'])
            ->where('updated_at', '<', Carbon::now()->subDays(7))
            ->orderBy('updated_at')
            ->get();

        return WeeklyReportResource::collection($reports);
    }

    // GET /api/placements/{id}/reports
    public function byPlacement($id)
    {
        $reports = WeeklyReport::where('placement_id', $id)
            ->orderBy('week_no')
            ->get();

        return WeeklyReportResource::collection($reports);
    }
}
