<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'number', 'level_id', 'locationable_type', 'locationable_id', 'locationable_name', 'picture_id', 'photo'];
    protected $dates = ['deleted_at'];

    public function level() {
        return $this->belongsTo(CandidateLevel::class, 'level_id');
    }

    public function locationable() {
        return $this->morphTo();
    }
}
