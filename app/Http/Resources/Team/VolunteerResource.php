<?php

namespace App\Http\Resources\Team;

use Illuminate\Http\Resources\Json\JsonResource;

class VolunteerResource extends JsonResource
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
            'nik' => $this->nik,
            'tps' => 'TPS ' . $this->locationable->name,
            'locationable_id' => $this->locationable_id,
            'address' => $this->address,
            'phone' => $this->phone,
            'information' => $this->information ?? '-',
        ];
    }
}
