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
            'level' => $this->level,
            'dapil' => $this->dapil,
            'locationable_id' => $this->locationable_id
        ];
    }
}
