<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\VoterCreated;

use Carbon\Carbon;

class Voter extends Model
{
    use SoftDeletes, VoterCreated;

    protected $fillable = ['kk', 'nik', 'name', 'birth_place', 'birth_date', 'marital_status', 'gender', 'addr_street', 'addr_rt', 'addr_rw', 'information', 'marital_status_id', 'disability_id', 'locationable_type', 'locationable_id', 'voting_place_id'];
    protected $dates = ['deleted_at', 'birth_date'];

    public function setBirthDateAttribute($birth_date) {
        $this->attributes['birth_date'] = Carbon::createFromFormat('d/m/Y', $birth_date)->format('Y-m-d');
    }

    public function locationable() {
        return $this->morphTo();
    }

    public function location() {
        return $this->hasOne(VoterLocation::class);
    }

    public function tps() {
        return $this->belongsTo(VotingPlace::class, 'voting_place_id')->withTrashed();
    }

    public function disability() {
        return $this->belongsTo(RefDisability::class, 'id');
    }
}
