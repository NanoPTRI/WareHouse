<?php

namespace App\Models;

use App\Models\HashId\HashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalletCustom extends Model
{
    use HasFactory,HashId;
    protected $table = 'pallet_custom';
    protected $guarded = ["id"];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    public function pallet()
    {
        return $this->belongsTo(Pallet::class, 'id_pallet', 'id');
    }

    public function inventori()
    {
        return $this->belongsTo(Inventori::class, 'id_inventori', 'PartID');
    }
}
