<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlacementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'student_id'     => $this->student_id,
            'supervisor_id'  => $this->supervisor_id,
            'required_weeks' => $this->required_weeks,
            'student_name'   => $this->student->name,
            'company_name'   => $this->company->name,
            'start_date'     => $this->start_date,
            'end_date'       => $this->end_date,
            'status'         => $this->status,
        ];
    }
}