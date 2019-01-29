<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteer extends Model
{
    use SoftDeletes;

    protected $fillable = ['nik', 'name', 'address', 'phone', 'information', 'user_id', 'locationable_type', 'locationable_id', 'created_by'];
    protected $dates = ['deleted_at'];

    public function locationable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
