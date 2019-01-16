<?php

namespace App\Http\Resources\Candidate;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return parent::toArray($request);
    }
}
