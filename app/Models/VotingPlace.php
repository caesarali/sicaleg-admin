<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingPlace extends Model
{
    protected $fillable = ['name', 'village_id'];

    protected $appends = ['alias'];

    public function getAliasAttribute() {
        return $this->attributes['alias'] = 'tps_id';
    }

    public function village() {
        return $this->belongsTo(Village::class);
    }

    public function parent() {
        return $this->village();
    }
}
