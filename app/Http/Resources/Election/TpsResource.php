<?php

namespace App\Http\Resources\Election;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Voter;

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
        return [
            'id' => $this->locationable->id ?? $this->id,
            'alias' => $this->locationable->alias ?? $this->alias,
            'name' => $this->locationable->name ?? $this->name,
            'parent' => $this->locationable->parent->name ?? $this->parent->name,
            'male' => $this->voters->where('gender', 'l')->count(),
            'female' => $this->voters->where('gender', 'm')->count(),
        ];
    }
}
