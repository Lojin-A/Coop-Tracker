<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Http\Resources\EvaluationResource;

class EvaluationApiController extends Controller
{
    // GET /api/placements/{id}/evaluation
    public function byPlacement($id)
    {
        $evaluation = Evaluation::where('placement_id', $id)->first();

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found'], 404);
        }

        return new EvaluationResource($evaluation);
    }
}
