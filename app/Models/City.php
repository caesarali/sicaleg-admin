<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'province_id'];

    public function getNameAttribute($value) {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function province() {
        return $this->belongsTo(Province::class);
    }

    public function parent() {
        return $this->province();
    }

    public function districts() {
        return $this->hasMany(District::class);
    }

    public function childs() {
        return $this->districts();
    }
}
