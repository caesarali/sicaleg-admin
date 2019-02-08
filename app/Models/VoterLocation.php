<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoterLocation extends Model
{
    protected $fillable = ['voter_id', 'province_id', 'city_id', 'district_id', 'village_id', 'voting_place_id'];

    public function voter() {
        return $this->belongsTo(Voter::class);
    }

    public function province() {
        return $this->belongsTo(Province::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }

    public function village() {
        return $this->belongsTo(Village::class);
    }

    public function tps() {
        return $this->belongsTo(VotingPlace::class, 'voting_place_id');
    }
}
