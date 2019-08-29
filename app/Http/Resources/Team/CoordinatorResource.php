<?php

namespace App\Http\Resources\Team;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Model\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\VotingPlace;

class CoordinatorResource extends JsonResource
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
            'address' => $this->address,
            'phone' => $this->phone,
            'information' => $this->information,
            'role' => $this->user->role->name,
            'location' => $this->locationable->name,
            'contribution' => $this->supporters->count(),
            $this->mergeWhen($this->locationable_type == City::class, [
                'village_id' => '',
                'district_id' => '',
                'city_id' => $this->locationable_id
            ]),
            $this->mergeWhen($this->locationable_type == District::class, [
                'village_id' => '',
                'district_id' => $this->locationable_id,
                'city_id' => $this->locationable->city_id
            ]),
            $this->mergeWhen($this->locationable_type == Village::class, [
                'village_id' => $this->locationable_id,
                'district_id' => $this->locationable->district_id,
                'city_id' => $this->locationable->district['city_id']
            ]),
        ];
    }
}
