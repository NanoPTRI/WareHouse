<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPallet extends Model
{
    use HasFactory;
    protected $table = 'temp_pallet';
    protected $guarded = ["id"];
    public $incrementing = true;
    protected $primaryKey = 'id';

    public function pallet()
    {
        return $this->belongsTo(Pallet::class, 'id_pallet', 'id');
    }
    public function palletCode()
    {
        return $this->belongsTo(PalletCode::class, 'id_pallet_code', 'id');
    }
}
