<?php

namespace App\Http\Resources\Team;

use Illuminate\Http\Resources\Json\JsonResource;

class TpsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return [
        //     'id' => $this->locationable->id ?? $this->id,
        //     'alias' => $this->locationable->alias ?? $this->alias,
        //     'name' => $this->locationable->name ?? $this->name,
        //     'parent' => $this->locationable->parent->name ?? $this->parent->name,
        //     'volunteers' => $this->volunteers->count(),
        // ];
        return VolunteerResource::collection($this->volunteers);
    }
}
