<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'               => $this->id,
            'placement_id'     => $this->placement_id,
            'technical_skills' => $this->technical_skills,
            'teamwork'         => $this->teamwork,
            'communication'    => $this->communication,
            'punctuality'      => $this->punctuality,
            'initiative'       => $this->initiative,
            'total'            => $this->total,
            'comments'         => $this->comments,
            'status'           => $this->status,
            'evaluated_at'     => $this->updated_at,
        ];
    }
}
