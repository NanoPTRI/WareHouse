<?php

namespace App\Service\Admin;

use App\Repository\Admin\AdminRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminServiceImpl implements AdminService
{
    protected $admin;

    /**
     * @param $admin
     */
    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }

    public function get($request,$date)
    {
        try {
            return $this->admin->get($request,$date);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function show($id)
    {
        try {
            return $this->admin->show($id);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function dataPallet($id)
    {
        try {
            $data= $this->admin->dataPallet($id);
            return $data;
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function inventori($id)
    {
        try {
            $dataIdPallet = $this->admin->dataIdPallet($id);
            $dataIdPallet2 = $this->admin->dataIdPalletCustom($id);
            $dataID =  $dataIdPallet->merge($dataIdPallet2)->unique()->values();
            $data= $this->admin->inventori($dataID);
            return $data;
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $deleteKebutuhan = $this->admin->destroyKebutuhanPengiriman($id);
            $deletePengiriman = $this->admin->destoryDataPengiriman($id);
            if ($deletePengiriman && $deleteKebutuhan){
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        }catch (Exception $exception){
            DB::rollBack();
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function getRunning($request, $date)
    {
        try {
            return $this->admin->getRunning($request, $date);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function getDataByID($id)
    {
        try {
            return $this->admin->getDataByID($id);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function updateData($data,$id)
    {
        try {
            return $this->admin->updateData($data,$id);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return false;
        }
    }

    public function getKebutuhanByIDP($id_data_pengiriman)
    {
        try {
            return $this->admin->getKebutuhanByIDP($id_data_pengiriman);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function qtyPlan($id)
    {
        try {
            return $this->admin->qtyPlan($id);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }
}
