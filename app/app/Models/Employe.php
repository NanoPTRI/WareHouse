<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Ms_User';
    protected $guarded = ["UserID"];
    protected $primaryKey = 'UserID';
    public $timestamps = false;    // nonaktifkan timestamps
    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function () {
            throw new Exception('Create operation is not allowed.');
        });

        static::updating(function () {
            throw new Exception('Update operation is not allowed.');
        });

        static::deleting(function () {
            throw new Exception('Delete operation is not allowed.');
        });
    }
}
