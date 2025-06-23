<?php

namespace App\Repository\Client;

use App\Models\Inventori;
use App\Models\DataPengiriman;
use Illuminate\Support\Carbon;
use App\Models\KebutuhanPengiriman;

class CheckerRepository
{
    protected $dataPengiriman;
    protected $kebutuhanKirim;
    protected $inventori;

    /**
     * @param $transaction
     */
    public function __construct(DataPengiriman $dataPengiriman,KebutuhanPengiriman $kebutuhanKirim, Inventori $inventori)
    {
        $this->dataPengiriman = $dataPengiriman;
        $this->kebutuhanKirim = $kebutuhanKirim;
        $this->inventori = $inventori;
    }

    public function getDataPengiriman()
    {
        return $this->dataPengiriman->newQuery()->whereNotNull('admin_confirmed')->whereNull('checker1')->get()->toArray();
    }

    public function getKebutuhanByIDP($id_data_pengiriman)
    {
        return $this->kebutuhanKirim->with('inventori')->where('id_data_pengiriman', $id_data_pengiriman);
    }

    public function updateChecker($id_data_pengiriman)
    {
        return $this->dataPengiriman->where('id',$id_data_pengiriman)->update([
            'checker1' => Carbon::now()
        ]);
    }

    public function getIdDataPengiriman()
    {
        return $this->dataPengiriman->whereHas('kebutuhuanPengiriman')->whereNotNull('admin_confirmed')->whereNull('checker1')->with('kebutuhuanPengiriman.inventori')->get();
    }


}
