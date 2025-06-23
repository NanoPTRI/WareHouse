<?php

namespace App\Models;

use App\Models\HashId\HashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    use HasFactory,HashId;
    protected $table = 'pallet';
    protected $guarded = ["id"];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    public function dataPengiriman()
    {
        return $this->hasMany(DataPengiriman::class, 'id_data_pengiriman', 'id');
    }
    public function palletCustom()
    {
        return $this->hasMany(PalletCustom::class, 'id_pallet', 'id');
    }
    public function inventori()
    {
        return $this->belongsTo(Inventori::class, 'id_inventori', 'PartID');
    }

    public function inventoriQty()
    {
        return $this->belongsTo(Inventori::class, 'id_inventori', 'PartID')->select('id','QtySalesPerPack');
    }

    public function tempPallet()
    {
        return $this->hasOne(TempPallet::class, 'id_pallet', 'id');
    }


}
