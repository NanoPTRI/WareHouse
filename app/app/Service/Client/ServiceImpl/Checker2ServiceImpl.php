<?php

namespace App\Service\Client\ServiceImpl;

use App\Repository\Client\Checker2Repository;
use App\Service\Client\Checker2Service;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Checker2ServiceImpl implements Checker2Service
{
    protected $checker2;

    /**
     * @param $checker2
     */
    public function __construct(Checker2Repository $checker2)
    {
        $this->checker2 = $checker2;
    }

    public function get($request)
    {
        try {
            return $this->checker2->get($request);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function getModal($id)
    {
        try {
            return $this->checker2->getModal($id);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function update($kode)
    {
        DB::beginTransaction();
        try {
            $cheker = $this->checker2->getPalletId($kode);
            $response = $this->checker2->update($cheker);
            if ($response){
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function store(mixed $data)
    {
        DB::beginTransaction();
        try {
            $getPallet = $this->checker2->getPalletByIdDataKirim($data['id']);
            if (!$getPallet){
                DB::rollBack();
                return false;
            }
            $updateDataKirim = $this->checker2->updateDataKirim($data['id']);
            $deleteTempPallet = $this->checker2->deleteTemp($getPallet);
            if ($deleteTempPallet && $updateDataKirim){
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

    public function updateQtyCustom(mixed $data, $id)
    {
        DB::beginTransaction();
        try {
            $getPallet = $this->checker2->updateQtyCustom($data, $id);
            if ($getPallet){
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

    public function updateQtySingle($id)
    {
        DB::beginTransaction();
        try {
            $destoryPallet = $this->checker2->destroyPalletSingle($id);
            $destroyQty = $this->checker2->updateQtySingle($id);

            if ($destroyQty && $destoryPallet){
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
}
