<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['name'];

    public function getNameAttribute($value) {
        return $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function cities() {
        return $this->hasMany(City::class);
    }

    public function childs() {
        return $this->cities();
    }
}
