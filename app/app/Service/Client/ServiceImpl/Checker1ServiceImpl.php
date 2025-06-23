<?php

namespace App\Service\Client\ServiceImpl;

use App\Repository\Client\Checker1Repository;
use App\Service\Client\Checker1Service;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Checker1ServiceImpl implements Checker1Service
{
    protected $checker1;

    /**
     * @param $checker1
     */
    public function __construct(Checker1Repository $checker1)
    {
        $this->checker1 = $checker1;
    }

    public function getData($request)
    {
        try {
            return $this->checker1->getData($request);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function getDataByIDP($id_data_pengiriman)
    {
        try {
            return $this->checker1->getDataByIDP($id_data_pengiriman);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function checkPallet($kode)
    {
        try {
            return $this->checker1->checkPallet($kode);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return false;
        }
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
//            single pallet
            if(empty($request['inventori']) && $request['OtherID']){
                $Inventori = $this->checker1->getIdInventoriByOtherID($request['OtherID']);

                $getQtyPlan = $this->checker1->getQtyPlan([$Inventori->PartID],$request['id_data_pengiriman']);
                $getItem = $this->checker1->getQtyItem([$Inventori->PartID],$request['id_data_pengiriman']);
                $getItemCustom = $this->checker1->getQtyItemCustom([$Inventori->PartID],$request['id_data_pengiriman']);

                if ($getItem == 0 && $getItemCustom == 0){
                    if ($Inventori->QtySalesPerPack > $getQtyPlan->qty){
                        DB::rollBack();
                        throw new Exception('Qty Over From Planning.');
                    }
                }

                $cekItemExistOnPlan = $getQtyPlan->qty - ($getItem + $getItemCustom + $Inventori->QtySalesPerPack) ;
                if ($cekItemExistOnPlan < 0){
                    DB::rollBack();
                    throw new Exception('Qty Over From Planning.');
                }

                $idPalletCode = $this->checker1->getIdPalletCodeByCode($request['pallet_code']);
                $store = $this->checker1->storeSingle($request,$Inventori->PartID);
                $cekExist = $this->checker1->checkExistOnTempPallet($idPalletCode->id);
                if($cekExist){
                    DB::rollBack();
                    throw new Exception('Failed Input Product.');
                }
                $response2 = $this->checker1->storeTempSingle($store->id,$idPalletCode->id);
                $response = !empty($store) && !empty($response2) ? true: false;

            }
//            multiple pallet
            elseif (!empty($request['inventori'])){
                $getQtyPlan = $this->checker1->getQtyPlanCustom($request['id_data_pengiriman'])->groupBy(function ($item) {
                    return $item['inventori']['OtherID'];
                })->map(fn($items) => $items->sum('qty'));

                $getItemPalletCustom = $this->checker1->getQtyItemAll($request['id_data_pengiriman'])->groupBy(function ($item) {
                    return $item['inventori']['OtherID'];
                })->map(fn($items) => $items->sum('inventori.QtySalesPerPack'));
                $getItemCakarCustom = $this->checker1->getQtyItemCustomAll($request['id_data_pengiriman'])->groupBy(function ($item) {
                    return $item['inventori']['OtherID'];
                })->map(fn($items) => $items->sum('qty'));
                foreach($request['inventori'] as $data){
                    $qtyPlan = $getQtyPlan[$data['id']] ?? 0;
                    $qtyCakar = $getItemCakarCustom[$data['id']] ?? 0;
                    $qtyPallet = $getItemPalletCustom[$data['id']]['inventori']['QtySalesPerPack'] ?? 0;
                    $cekItemExistOnPlan = $qtyPlan - ($qtyCakar +$qtyPallet + $data['qty']);
                    if ($cekItemExistOnPlan < 0){
                        DB::rollBack();
                        throw new Exception('Qty Over From Planning.');
                    }

                }

                $pallet = $this->checker1->createPallet($request);
                $idPalletCode = $this->checker1->getIdPalletCodeByCode($request['pallet_code']);
                if(empty($pallet)){
                    DB::rollBack();
                    throw new Exception('Not Pallet Exist.');
                }
                $store = $this->checker1->storeCustomPallet($request,$pallet->id);

                if(empty($store)){
                    DB::rollBack();
                    throw new Exception('Failed Input Product.');
                }
                $cekExist = $this->checker1->checkExistOnTempPallet($idPalletCode->id);

                if($cekExist){
                    DB::rollBack();
                    throw new Exception('Failed Input Product.');
                }
                $response = $this->checker1->storeTemp($idPalletCode->id,$pallet->id);
            }

            if ($response){
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            DB::rollBack();
            throw new HttpResponseException(response()->json(['message' => $exception->getMessage()],400));
        }
    }

    public function getCustomOtherIDs($id)
    {
        try {
            return $this->checker1->getCustomOtherIDs($id);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return false;
        }
    }

    public function getCustomQty($id)
    {
        try {
            return $this->checker1->getCustomQty($id);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return false;
        }
    }

    public function checkItem($kode,$qty,$id_data_pengiriman)
    {
        try {
            $kode = $this->checker1->checkItem($kode);
            $getQtyPlan = $this->checker1->getQtyPlan([$kode->PartID],$id_data_pengiriman);
            $getItem = $this->checker1->getQtyItem([$kode->PartID],$id_data_pengiriman);
            $getItemCustom = $this->checker1->getQtyItemCustom([$kode->PartID],$id_data_pengiriman);
            $cekItemExistOnPlan = $getQtyPlan->qty - ($qty + $getItem + $getItemCustom) ;
            if ($cekItemExistOnPlan < 0){
                DB::rollBack();
                throw new Exception('Qty Over From Planning.');
            }
            return $kode;
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            throw new HttpResponseException(response()->json(['message' => $exception->getMessage()],400));
        }
    }

    public function destroyPallet($id)
    {
        DB::beginTransaction();

        try {
            $response3 = true;

            $idPallet = $this->checker1->getIdPallet($id);

            $cekExistInCostum = $this->checker1->checkExistInCustom($idPallet);

            if ($cekExistInCostum){
                $response3 = $this->checker1->deleteCustom($idPallet);
            }
            $response2 = $this->checker1->destroyTempPallet($id);
            $response =  $this->checker1->destroyPallet($idPallet);

            if ($response && $response2 && $response3){
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        }catch (Exception $exception){
            DB::rollBack();
            Log::error('exception',[$exception->getMessage()]);
            return false;
        }
    }

    public function updateChecker($id)
    {
        try {
            $cekPallet =  $this->checker1->checkPalletInput($id);
            if(!$cekPallet){
                return false;
            }
            return $this->checker1->updateChecker($id);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return false;
        }
    }

    public function getKebutuhanByIDP($id_data_pengiriman)
    {
        try {
            return $this->checker1->getKebutuhanByIDP($id_data_pengiriman);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function dataPallet($id_data_pengiriman)
    {
        try {
            $data= $this->checker1->dataPallet($id_data_pengiriman);
            return $data;
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }
    public function qtyPlan($id_data_pengiriman)
    {
        try {
            $data= $this->checker1->qtyPlan($id_data_pengiriman);
            return $data;
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }
    public function inventori($idinventori)
    {
        try {
            $data= $this->checker1->inventori($idinventori);
            return $data;
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }
}
