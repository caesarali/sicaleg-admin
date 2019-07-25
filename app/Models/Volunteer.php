<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\CreatedBy;

class Volunteer extends Model
{
    use CreatedBy, SoftDeletes;

    protected $fillable = ['nik', 'name', 'address', 'phone', 'information', 'user_id', 'locationable_type', 'locationable_id', 'created_by'];
    protected $dates = ['deleted_at'];

    public function locationable() {
        return $this->morphTo();
    }

    public function tps() {
        return $this->belongsTo(VotingPlace::class, 'voting_place_id');
    }

    public function supporters() {
        return $this->hasMany(Supporter::class, 'created_by', 'user_id');
    }

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
