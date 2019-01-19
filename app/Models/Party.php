<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Party extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'fullname', 'number', 'logo', 'picture_id'];
    protected $dates = ['deleted_at'];
}
