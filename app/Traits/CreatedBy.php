<?php

namespace App\Traits;

use Auth;

trait CreatedBy
{
    public static function bootCreatedBy()
    {
        static::saving(function ($model) {
            // $model->created_by = auth('api')->user()->id;
        });
    }
}
