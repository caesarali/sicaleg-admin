<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = ['kk', 'nik', 'name', 'birth_place', 'birth_date', 'marital_status', 'gender', 'addr_street', 'addr_rt', 'addr_rw', 'information', 'marital_status_id', 'disability_id', 'locationable_type', 'locationable_id'];

}
