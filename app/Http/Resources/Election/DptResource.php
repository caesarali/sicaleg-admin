<?php

namespace App\Http\Resources\Election;

use Illuminate\Http\Resources\Json\JsonResource;

class DptResource extends JsonResource
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
            'kk' => $this->kk,
            'name' => $this->name,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date->format('d/m/Y'),
            'marital_status' => $this->marital_status,
            'disability_id' => $this->disability_id,
            'gender' => $this->gender,
            'addr_street' => $this->addr_street,
            'addr_rt' => $this->addr_rt,
            'addr_rw' => $this->addr_rw,
            'tps' => $this->locationable->name
        ];
    }
}
