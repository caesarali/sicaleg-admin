<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerLocation extends Model
{
    use SoftDeletes;

    protected $fillable = ['volunteer_id', 'province_id', 'city_id', 'district_id', 'village_id', 'voting_place_id'];
    protected $dates = ['deleted_at'];
}
