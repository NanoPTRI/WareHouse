<?php

namespace App\Repository\Admin;

use App\Models\DataPengiriman;
use App\Models\Inventori;
use App\Models\KebutuhanPengiriman;
use App\Models\Pallet;
use App\Models\PalletCustom;

class AdminRepository
{
    protected $dataPengiriman;
    protected $inventori;
    protected $pallet;
    protected $palletCustom;
    protected $kebutuhanPengiriman;

    /**
     * @param $dataPengiriman
     */
    public function __construct(DataPengiriman $dataPengiriman,Inventori $inventori,Pallet $pallet,PalletCustom $palletCustom,KebutuhanPengiriman $kebutuhanPengiriman)
    {
        $this->dataPengiriman = $dataPengiriman;
        $this->inventori = $inventori;
        $this->pallet = $pallet;
        $this->palletCustom = $palletCustom;
        $this->kebutuhanPengiriman = $kebutuhanPengiriman;
    }

    public function get($request,$date)
    {
        $data =  $this->dataPengiriman->where('tanggal_pengiriman', $date)
            ->whereNotNull('checker1')->whereNotNull('checker2')->whereNotNull('checker3');

        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchTerm = $request->input('search')['value'];
            $data->where('tanggal_pengiriman', 'LIKE', "%{$searchTerm}%");
        }

        if (!empty($request->input('order')[0]['column']) && $request->input('order')[0]['column'] == 2){
            $data->orderBy('tanggal_pengiriman', $request->input('order')[0]['dir']);
        }else{
            $data->orderBy('updated_at', 'desc');
        }
        return $data;
    }
    public function getRunning($request,$date)
    {
        $data =  $this->dataPengiriman->where('tanggal_pengiriman', $date)->whereNull('checker3');

        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchTerm = $request->input('search')['value'];
            $data->where('tanggal_pengiriman', 'LIKE', "%{$searchTerm}%");
        }

        if (!empty($request->input('order')[0]['column']) && $request->input('order')[0]['column'] == 2){
            $data->orderBy('tanggal_pengiriman', $request->input('order')[0]['dir']);
        }else{
            $data->orderBy('updated_at', 'desc');
        }
        return $data;
    }
    public function show($id)
    {
        return $this->dataPengiriman->where('id',$id)->firstOrFail();
    }

    public function inventori($id)
    {
        return $this->inventori->whereIn('PartID',$id)->get();
    }

    public function dataIdPallet($id)
    {
        return $this->pallet->where('id_data_pengiriman',$id)->pluck('id_inventori');
    }
    public function dataIdPalletCustom($id)
    {
        return $this->palletCustom->whereHas('pallet',function ($query) use ($id) {
            $query->where('id_data_pengiriman',$id);
        })->pluck('id_inventori');
    }

    public function dataPallet($id)
    {
        $data = $this->palletCustom->whereHas('pallet', function ($query) use ($id) {
            $query->where('id_data_pengiriman', $id);
        })->get()->groupBy('id_inventori')->map(function ($group) {
            return $group->pluck('qty');
        })->toArray();



        $data2= $this->pallet
            ->where('id_data_pengiriman', $id)
            ->whereNotNull('id_inventori')
            ->with('inventoriQty','palletCustom')
            ->get()
            ->groupBy('id_inventori')
            ->map(function ($group) {
                return $group->pluck('inventoriQty.QtySalesPerPack');
            })->toArray();
        $result = [];

        foreach ($data2 as $key => $values) {
            $result[$key] = $values;
            if (isset($data[$key])) {
                $result[$key] = array_merge($result[$key], $data[$key]);
            }
        }

        foreach ($data as $key => $values) {
            if (!isset($result[$key])) {
                $result[$key] = $values;
            }
        }
        return collect($result);

    }

    public function destoryDataPengiriman($id)
    {
        return $this->dataPengiriman->where('id',$id)
            ->whereNull('checker1')->whereNull('checker2')->whereNull('checker3')->delete();
    }

    public function destroyKebutuhanPengiriman($id)
    {
        return $this->kebutuhanPengiriman->where('id_data_pengiriman',$id)->delete();
    }

    public function getDataByID($id)
    {
        return $this->dataPengiriman->where('id', $id)->firstOrFail();
    }

    public function updateData($data,$id)
    {
        return $this->dataPengiriman->where('id',$id)->update($data);
    }

    public function getKebutuhanByIDP($id_data_pengiriman)
    {
        return $this->kebutuhanPengiriman->with('inventori')->where('id_data_pengiriman', $id_data_pengiriman);
    }

    public function qtyPlan($id)
    {
        return $this->kebutuhanPengiriman->where('id_data_pengiriman',$id)->select('qty','id_data_pengiriman','id_inventori')->get();
    }
}
