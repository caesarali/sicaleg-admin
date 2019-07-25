<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedBy;
use Carbon\Carbon;

class Supporter extends Model
{
    use SoftDeletes, CreatedBy;

    protected $fillable = ['voter_id', 'locationable_type', 'locationable_id'];
    protected $casts = [
        'locationable_id' => 'string',
    ];

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function locationable() {
        return $this->morphTo();
    }

    public function voter() {
        return $this->belongsTo(Voter::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
