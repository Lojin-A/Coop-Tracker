<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'placement_id'   => $this->placement_id,
            'week_no'        => $this->week_no,
            'status'         => $this->status,
            'has_attachment' => (bool) $this->file_path,
            'feedback'       => $this->feedback,
            'submitted_at'   => $this->updated_at,
        ];
    }
}
