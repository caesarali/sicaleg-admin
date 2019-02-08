<?php

namespace App\Http\Resources\Election;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

use App\Models\VotingPlace;
use App\Models\Voter;

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
        $tps = VotingPlace::all()->where($this->locationable->alias ?? $this->alias, $this->locationable->id ?? $this->id);
        $tps_id = $tps->pluck('id');
        $voters = Voter::whereIn('voting_place_id', $tps_id)->get();
        return [
            'id' => $this->locationable->id ?? $this->id,
            'alias' => $this->locationable->alias ?? $this->alias,
            'name' => $this->locationable->name ?? $this->name,
            'parent' => $this->locationable->parent->name ?? $this->parent->name,
            'tps' => $tps->count(),
            'male' => $voters->where('gender', 'l')->count(),
            'female' => $voters->where('gender', 'p')->count(),
        ];
    }
}
