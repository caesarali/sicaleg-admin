<?php

namespace App\Http\Resources\Monitoring;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class LastAcitivitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            // 'date' => Carbon::parse($this->getOriginal('created_at'))->diffForHumans(),
            'date' => $this->created_at,
            'user' => $this->createdBy->load('volunteer.locationable', 'roles'),
            'voter' => $this->voter
        ];
    }
}
