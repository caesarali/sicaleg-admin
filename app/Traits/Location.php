<?php

namespace App\Traits;

use Auth;

trait Location
{
    public static function bootLocation()
    {
        static::saving(function ($model) {
            if (condition) {
                # code...
            }
            $model->created_by = Auth::id();
        });
    }
}
