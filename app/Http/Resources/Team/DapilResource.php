<?php

namespace App\Http\Resources\Team;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\VotingPlace;
use App\Models\Volunteer;

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
        $location = $this->locationable ?? $this;
        $tps = VotingPlace::all()->where($location->alias, $location->id);
        $tps_id = $tps->pluck('id');
        return [
            'id' => $location->id,
            'alias' => $location->alias,
            'name' => $location->name,
            'parent' => $location->parent->name,
            'tps' => VotingPlace::all()->where($location->alias, $location->id)->count(),
            'volunteers' => Volunteer::whereIn('locationable_id', $tps_id)->count()
        ];
    }
}
