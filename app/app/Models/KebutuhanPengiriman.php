<?php

namespace App\Models;

use App\Models\HashId\HashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanPengiriman extends Model
{
    use HasFactory,HashId;
    protected $table = 'kebutuhan_pengiriman';
    protected $guarded = ["id"];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    public function dataPengiriman()
    {
        return $this->belongsTo(DataPengiriman::class, 'id_data_pengiriman', 'id');
    }

    public function inventori()
    {
        return $this->belongsTo(Inventori::class, 'id_inventori', 'PartID');
    }
}
