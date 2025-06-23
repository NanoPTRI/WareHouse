<?php

namespace App\Models\HashId;

use Illuminate\Support\Str;

trait HashId
{
    protected static function bootHashId()
    {
        static::creating(function ($model){
            if(empty($model->{$model->getKeyName()})){
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }
}
