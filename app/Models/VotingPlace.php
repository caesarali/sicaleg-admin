<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingPlace extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'village_id'];
    protected $dates = ['deleted_at'];
    protected $appends = ['alias', 'district_id', 'city_id', 'province_id'];

    public function getAliasAttribute() {
        return $this->attributes['alias'] = 'tps_id';
    }

    public function getDistrictIdAttribute() {
        return$this->attributes['district_id'] = $this->village->district_id;
    }

    public function getCityIdAttribute() {
        return $this->attributes['city_id'] = $this->village->district->city_id;
    }

    public function getProvinceIdAttribute() {
        return $this->attributes['province_id'] = $this->village->district->city->province_id;
    }

    public function village() {
        return $this->belongsTo(Village::class);
    }

    public function voters() {
        return $this->morphMany(Voter::class, 'locationable');
    }

    public function parent() {
        return $this->village();
    }
}
