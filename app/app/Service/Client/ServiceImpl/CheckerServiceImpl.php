<?php

namespace App\Service\Client\ServiceImpl;

use App\Repository\Client\CheckerRepository;
use App\Service\Client\CheckerService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckerServiceImpl implements CheckerService
{
    protected $checker;

    /**
     * @param $checker
     */
    public function __construct(CheckerRepository $checker)
    {
        $this->checker = $checker;
    }

    public function getDataPengiriman()
    {
        try {
            return $this->checker->getDataPengiriman();
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function getKebutuhanByIDP($id_data_pengiriman)
    {
        try {
            return $this->checker->getKebutuhanByIDP($id_data_pengiriman);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }

    public function updateChecker($id_data_pengiriman)
    {
        try {
            return $this->checker->updateChecker($id_data_pengiriman);
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return false;
        }
    }

    public function getDataPrint()
    {
        try {
            $getIdPengiriman = $this->checker->getIdDataPengiriman();
            return $getIdPengiriman;
        }catch (Exception $exception){
            Log::error('exception',[$exception->getMessage()]);
            return [];
        }
    }
}
