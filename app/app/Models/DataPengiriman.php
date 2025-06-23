<?php

namespace App\Models;

use App\Models\HashId\HashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPengiriman extends Model
{
    use HasFactory,HashId;
    protected $table = 'data_pengiriman';
    protected $guarded = ["id"];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    public function kebutuhuanPengiriman()
    {
        return $this->hasMany(KebutuhanPengiriman::class, 'id_data_pengiriman', 'id');
    }

    public function pallet()
    {
        return $this->hasMany(Pallet::class, 'id_data_pengiriman', 'id');
    }
}
