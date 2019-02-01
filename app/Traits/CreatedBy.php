<?php

namespace App\Traits;

use Auth;

trait CreatedBy
{
    public static function bootCreatedBy()
    {
        static::creating(function ($model) {
            $model->created_by = auth('api')->user()->id;
        });
    }
}
