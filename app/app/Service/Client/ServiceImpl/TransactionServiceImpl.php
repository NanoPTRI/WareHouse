<?php

namespace App\Service\Client\ServiceImpl;

use App\Repository\Client\TransactionRepository;
use App\Service\Client\TransactionService;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionServiceImpl implements TransactionService
{
    protected $transaction;

    /**
     * @param $transaction
     */
    public function __construct(TransactionRepository $transaction)
    {
        $this->transaction = $transaction;
    }

    public function storeTransaction(mixed $data)
    {
        DB::beginTransaction();
        try {
           $response = $this->transaction->storeTransaction($data);
           if (!$response){
               DB::rollBack();
               return false;
           }
           DB::commit();
           return true;
        }catch (Exception $exception){
            DB::rollBack();
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function getViewData($request)
    {
        try {
            return $this->transaction->getViewData($request);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function getDataByID($id)
    {
        try {
            return $this->transaction->getDataByID($id);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function updateData($data,$id)
    {
        try {
            return $this->transaction->updateData($data,$id);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return false;
        }
    }

    public function updateConfirmed($id)
    {
        DB::beginTransaction();
        try {
            $cekColumn = $this->transaction->cekColumn($id);
            if(!$cekColumn){
                DB::rollBack();
                return false;
            }
            $response =  $this->transaction->updateConfirmed($id);
            if ($response){
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

    public function getKebutuhanByIDP($id_data_pengiriman)
    {
        try {
            return $this->transaction->getKebutuhanByIDP($id_data_pengiriman);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }
}
