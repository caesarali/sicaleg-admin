<?php

namespace App\Traits;

use App\Models\VoterLocation;

trait VoterCreated
{
    public static function bootVoterCreated()
    {
        static::created(function ($model) {
            $location = VoterLocation::updateOrCreate(
                ['voter_id' => $model->id],
                [
                    'voting_place_id' => $model->voting_place_id,
                    'village_id' => $model->tps->village_id,
                    'district_id' => $model->tps->village->district_id,
                    'city_id' => $model->tps->village->district->city_id,
                    'province_id' => $model->tps->village->district->city->province_id
                ]
            );
        });
    }
}
