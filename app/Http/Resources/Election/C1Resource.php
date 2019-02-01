<?php

namespace App\Http\Resources\Election;

use Illuminate\Http\Resources\Json\JsonResource;

class C1Resource extends JsonResource
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
        $prefixName = '';
        if ($location->alias == 'tps_id') {
            $prefixName = 'TPS ';
        }
        return [
            'id' => $location->id,
            'alias' => $location->alias,
            'name' => $prefixName . $location->name,
            'quick_count' => 0,
            'documentations' => []
        ];
    }
}
