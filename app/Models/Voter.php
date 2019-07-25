<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\VoterCreated;

use Carbon\Carbon;

class Voter extends Model
{
    use SoftDeletes;

    protected $fillable = ['kk', 'nik', 'name', 'birth_place', 'birth_date', 'marital_status', 'gender', 'addr_street', 'addr_rt', 'addr_rw', 'information', 'disability_id', 'voting_place_id'];
    protected $dates = ['birth_date'];
    protected $appends = ['age', 'is_supporter'];
    // protected $appends = ['age', 'village', 'district', 'city', 'province', 'is_supporter'];

    public function getIsSupporterAttribute() {
        return $this->attributes['is_supporter'] = $this->supporter()->exists();
    }

    public function setBirthDateAttribute($birth_date) {
        $this->attributes['birth_date'] = Carbon::createFromFormat('d/m/Y', $birth_date)->format('Y-m-d');
    }

    public function getAgeAttribute() {
        $now = now();
        $birthDate = $this->birth_date;
        $diff = $now->diff($birthDate);
        return $diff->y;
    }

    public function tps() {
        return $this->belongsTo(VotingPlace::class, 'voting_place_id')->withTrashed();
    }

    // public function getVillageAttribute() {
    //     return $this->tps->village;
    // }

    // public function getDistrictAttribute() {
    //     return $this->village->district;
    // }

    // public function getCityAttribute() {
    //     return $this->district->city;
    // }

    // public function getProvinceAttribute() {
    //     return $this->city->province;
    // }

    public function disability() {
        return $this->belongsTo(RefDisability::class, 'id');
    }

    public function supporter() {
        return $this->hasOne(Supporter::class);
    }
}
