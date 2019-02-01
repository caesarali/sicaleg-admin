<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Voter extends Model
{
    use SoftDeletes;

    protected $fillable = ['kk', 'nik', 'name', 'birth_place', 'birth_date', 'marital_status', 'gender', 'addr_street', 'addr_rt', 'addr_rw', 'information', 'marital_status_id', 'disability_id', 'locationable_type', 'locationable_id', 'tps_id'];
    protected $dates = ['birth_date', 'deleted_at'];

    public function setBirthDateAttribute($birth_date) {
        $this->attributes['birth_date'] = Carbon::createFromFormat('d/m/Y', $birth_date)->format('Y-m-d');
    }

    public function locationable() {
        return $this->morphTo();
    }

    public function tps() {
        return $this->belongsTo(VotingPlace::class, 'tps_id')->withTrashed();
    }

    public function disability() {
        return $this->belongsTo(RefDisability::class, 'id');
    }
}
