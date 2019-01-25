<?php

namespace App\Http\Resources\Election;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\VotingPlace;

class DapilResource extends JsonResource
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
            'id' => $this->locationable->id ?? $this->id,
            'alias' => $this->locationable->alias ?? $this->alias,
            'name' => $this->locationable->name ?? $this->name,
            'parent' => $this->locationable->parent->name ?? $this->parent->name,
            'tpsCount' => VotingPlace::all()->where($this->locationable->alias ?? $this->alias, $this->locationable->id ?? $this->id)->count()
        ];
    }
}
