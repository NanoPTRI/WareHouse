<?php

namespace App\Models;

use App\Models\HashId\HashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalletCode extends Model
{
    use HasFactory,HashId;
    protected $table = 'pallet_code';
    protected $guarded = ["id"];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    public function tempPallet()
    {
        return $this->hasOne(TempPallet::class, 'id_pallet_code', 'id');
    }
}
