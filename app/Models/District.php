<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name', 'city_id'];

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
