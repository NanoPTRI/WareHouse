<?php

namespace App\Repository\Client;

use App\Models\DataPengiriman;
use App\Models\Inventori;
use App\Models\KebutuhanPengiriman;
use App\Models\Pallet;
use App\Models\PalletCode;
use App\Models\PalletCustom;
use App\Models\TempPallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\ItemNotFoundException;

class Checker1Repository
{
    protected $dataPengiriman;
    protected $palletCode;
    protected $inventori;
    protected $pallet;
    protected $palletCustom;
    protected $tempPallet;
    protected $kebutuhanKirim;

    /**
     * @param $transaction
     */
    public function __construct(DataPengiriman $dataPengiriman,PalletCode $palletCode, Inventori $inventori, Pallet $pallet, PalletCustom $palletCustom, TempPallet $tempPallet, KebutuhanPengiriman $kebutuhanKirim)
    {
        $this->dataPengiriman = $dataPengiriman;
        $this->palletCode = $palletCode;
        $this->inventori = $inventori;
        $this->pallet = $pallet;
        $this->palletCustom = $palletCustom;
        $this->tempPallet = $tempPallet;
        $this->kebutuhanKirim = $kebutuhanKirim;
    }

    public function getData($request)
    {
        $data = $this->dataPengiriman->newQuery()
            ->whereNotNull('checker1')
            ->whereNull('checker2');
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchTerm = $request->input('search')['value'];
            // 'tanggal_pengiriman', 'tujuan', 'expedisi', 'mulai', 'sampai',
            $data->where(function ($query) use ($searchTerm) {
                $query->where('data_pengiriman.tanggal_pengiriman', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('data_pengiriman.tujuan', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('data_pengiriman.expedisi', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('data_pengiriman.mulai', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('data_pengiriman.sampai', 'LIKE', "%{$searchTerm}%");
            });
        }

        if (!empty($request->input('order')[0]['column'])){
            switch($request->input('order')[0]['column']){
                case 1:
                    $data->orderBy('tanggal_pengiriman', $request->input('order')[0]['dir']);
                    break;
                case 2:
                    $data->orderBy('tujuan', $request->input('order')[0]['dir']);
                    break;
                case 3:
                    $data->orderBy('ekspedisi', $request->input('order')[0]['dir']);
                    break;
                case 4:
                    $data->orderBy('mulai', $request->input('order')[0]['dir']);
                    break;
                case 5:
                    $data->orderBy('sampai', $request->input('order')[0]['dir']);
                    break;
            }
        }
        return $data;
    }

    public function getDataByIDP($id_data_pengiriman)
    {
        return $this->pallet->where('id_data_pengiriman', $id_data_pengiriman)
            ->whereHas('tempPallet')->with('tempPallet.PalletCode',"palletCustom.inventori","inventori")->get();
        return $this->pallet->where('id_data_pengiriman', $id_data_pengiriman)
            ->whereHas('tempPallet')->with('tempPallet.PalletCode',"palletCustom.inventori","inventori")->get();
    }

    public function checkPallet($kode)
    {
        return $this->palletCode->where('code', $kode)->whereDoesntHave("tempPallet")->exists();
    }

    public function storeCustomPallet($request,$id)
    {
        $data = [];
        foreach($request['inventori'] as $data){
            $idInventori = $this->getIdInventoriByOtherID($data['id']);
            $response = $this->palletCustom->create([
                'id_inventori' => $idInventori->PartID,
                'qty' => $data['qty'],
                'id_pallet' => $id,
            ]);

            if(!$response) {
                return false;
            }
            $data[]= $response->id;
        }
        return $data;
    }

    public function storeSingle($request,$idInventori)
    {
        return $this->pallet->create([
            'id_data_pengiriman' => $request['id_data_pengiriman'],
            'id_inventori' => $idInventori
        ]);
    }

    public function getIdInventoriByOtherID($OtherID)
    {
        return $this->inventori->where('OtherID',$OtherID)->select("PartID")->firstOrFail();
    }

    public function getQtyPlan($idInventori,$id_data_pengiriman)
    {
        return $this->kebutuhanKirim->where('id_data_pengiriman',$id_data_pengiriman)->where('id_inventori',$idInventori)->select("qty")->firstOrFail();
    }

    public function getQtyPlanCustom($id_data_pengiriman)
    {
        return $this->kebutuhanKirim->where('id_data_pengiriman',$id_data_pengiriman)->select("id_inventori","qty")->with('inventori')->get();
    }
    public function getQtyItem($idInventori,$idDataPengiriman)
    {
        return $this->pallet
            ->where('id_inventori', $idInventori)
            ->where('id_data_pengiriman', $idDataPengiriman)
            ->with('inventori')
            ->get()
            ->sum(function ($pallet) {
                return optional($pallet->inventori)->QtySalesPerPack ?? 0;
            });
    }

    public function getQtyItemAll($idDataPengiriman)
    {
        return $this->pallet
            ->where('id_data_pengiriman', $idDataPengiriman)
            ->whereNotNull('id_inventori')
            ->with('inventori')
            ->get();
    }

    public function getQtyItemCustom($idInventori,$idDataPengiriman)
    {
        return $this->palletCustom->whereHas('pallet',function ($query) use ($idDataPengiriman) {
            $query->where('id_data_pengiriman',$idDataPengiriman);
        })->where('id_inventori',$idInventori)->sum('qty');
    }

    public function getQtyItemCustomAll($idDataPengiriman)
    {
        return $this->palletCustom->whereHas('pallet',function ($query) use ($idDataPengiriman) {
            $query->where('id_data_pengiriman',$idDataPengiriman);
        })->with('inventori')->get();
    }
    public function createPallet($request)
    {
        return $this->pallet->create([
            'id_data_pengiriman' => $request["id_data_pengiriman"],
        ]);
    }

    public function storeTempSingle($id,$idPallet)
    {
        return $this->tempPallet->create([
            'id_pallet' => $id,
            'id_pallet_code' => $idPallet
        ]);
    }

    public function checkExistOnTempPallet($id)
    {
        return $this->tempPallet->where('id_pallet_code',$id)->exists();
    }

    public function storeTemp($code,$idPallet)
    {
        return $this->tempPallet->create([
            'id_pallet' => $idPallet,
            'id_pallet_code' => $code
        ]);
    }

    public function getIdPalletCodeByCode($pallet_code)
    {
        return $this->palletCode->where('code',$pallet_code)->select("id")->lockForUpdate()->firstOrFail();
    }

    public function getCustomOtherIDs($id)
    {
        return $this->palletCustom
            ->where('id_pallet', $id)
            ->with('inventori')
            ->get()
            ->map(function ($item) {
                return optional($item->inventori)->OtherID;
            })
            ->filter()
            ->values()
            ->toArray();    }

    public function getCustomQty($id)
    {
        return $this->palletCustom->where('id_pallet',$id)->pluck('qty')->toArray();
    }

    public function checkItem($kode)
    {
        try {
            return $this->inventori
                ->where('OtherID', $kode)
                ->select("PartID", "OtherID")
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ItemNotFoundException("Item dengan kode {$kode} tidak ditemukan.");
        }
    }

    public function destroyTempPallet($id)
    {
        return $this->tempPallet->where('id',$id)->delete();
    }
    public function destroyPallet($idPallet)
    {
        return $this->pallet->where('id',$idPallet->id)->delete();
    }
    public function getIdPallet($id)
    {
        return $this->pallet->whereHas('tempPallet', function ($query) use ($id){
            $query->where('id',$id);
        })->lockForUpdate()->firstOrFail();
    }

    public function checkExistInCustom($idPallet)
    {
        return $this->palletCustom->where('id_pallet',$idPallet->id)->exists();
    }

    public function deleteCustom($idPallet)
    {
        return $this->palletCustom->where('id_pallet',$idPallet->id)->delete();
    }

    public function updateChecker($id)
    {
        return $this->dataPengiriman->where('id',$id)->update([
            'checker2' => Carbon::now()
        ]);
    }

    public function checkPalletInput($id)
    {
        return $this->pallet->where('id_data_pengiriman',$id)->exists();
    }

    public function getKebutuhanByIDP($id_data_pengiriman)
    {
        return $this->kebutuhanKirim->with('inventori')->where('id_data_pengiriman', $id_data_pengiriman);
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
    public function qtyPlan($id)
    {
        return $this->kebutuhanKirim->where('id_data_pengiriman',$id)->select('qty','id_data_pengiriman','id_inventori')->get();
    }

    public function inventori($id)
    {
        return $this->inventori->whereIn('PartID',$id)->get();
    }
}
