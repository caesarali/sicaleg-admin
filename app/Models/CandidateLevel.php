<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateLevel extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'name', 'locationable', 'locationable_child'];
    protected $dates = ['deleted_at'];


}
