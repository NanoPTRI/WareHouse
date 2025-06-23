<?php

namespace App\Models;

use App\Models\Scopes\InvetoriScope;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';

    protected $table = 'Ms_Part';
    protected $guarded = ["PartID"];
    protected $primaryKey = 'PartID';
    protected $keyType = 'string';

    protected static function booted()
    {
        static::addGlobalScope(new InvetoriScope());
    }
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

    public function pallet()
    {
        return $this->hasMany(Pallet::class, 'id_inventori', 'PartID');
    }

    public function palletCustom()
    {
        return $this->hasMany(Pallet::class, 'id_inventori', 'PartID');
    }
}
