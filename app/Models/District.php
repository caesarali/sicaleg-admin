<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name', 'city_id'];

    protected $appends = ['alias', 'detail'];

    public function getDetailAttribute() {
        return $this->name . ', ' . $this->city->name;
    }

    public function getAliasAttribute() {
        return $this->attributes['alias'] = 'district_id';
    }

    public function getNameAttribute($value) {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function parent() {
        return $this->city();
    }

    public function villages() {
        return $this->hasMany(Village::class);
    }

    public function childs() {
        return $this->villages();
    }
}
