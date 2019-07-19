<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedBy;

class Supporter extends Model
{
    use SoftDeletes, CreatedBy;

    protected $fillable = ['voter_id'];

    public function voter() {
        return $this->belongsTo(Voter::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
