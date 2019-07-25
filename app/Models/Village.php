<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = ['name', 'district_id'];

    protected $appends = ['alias', 'detail'];

    public function getDetailAttribute() {
        return $this->name . ', ' . $this->district->name . ', ' . $this->district->city->name;
    }

    public function getAliasAttribute() {
        return $this->attributes['alias'] = 'village_id';
    }

    public function getNameAttribute($value) {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function district() {
        return $this->belongsTo(District::class);
    }

    public function parent() {
        return $this->district();
    }

    public function tps() {
        return $this->hasMany(VotingPlace::class, 'village_id');
    }

    public function childs() {
        return $this->tps();
    }

    public function voters() {
        return $this->morphMany(Voter::class, 'locationable');
    }
}
