<?php

namespace App\Http\Resources\Voter\DPT;

use Illuminate\Http\Resources\Json\JsonResource;

class ByTpsResource extends JsonResource
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
            'parent' => $this->locationable->parent->name ?? $this->parent->name
        ];
    }
}
