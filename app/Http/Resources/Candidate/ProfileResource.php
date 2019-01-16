<?php

namespace App\Http\Resources\Candidate;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\CandidateArea;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'locationable_id' => $this->locationable_id,
            'locationable_name' => $this->locationable_name,
            'level' => $this->level->name,
            'dapil_name' => $this->locationable_name,
            'dapil_locations' => DapilResource::collection(CandidateArea::all())
        ];
    }
}
