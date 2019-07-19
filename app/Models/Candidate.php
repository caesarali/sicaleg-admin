<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'number', 'level', 'dapil', 'locationable_type', 'locationable_id', 'picture_id'];
    protected $dates = ['deleted_at'];

    public function candidateLevel() {
        return $this->belongsTo(CandidateLevel::class, 'level', 'code');
    }

    public function locationable() {
        return $this->morphTo();
    }
}
