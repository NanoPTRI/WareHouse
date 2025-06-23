<?php

namespace App\Service\Admin;

use App\Repository\Admin\PalletRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class PalletServiceImpl implements PalletService
{
    protected $pallet;

    /**
     * @param $pallet
     */
    public function __construct(PalletRepository $pallet)
    {
        $this->pallet = $pallet;
    }

    public function get($request)
    {
        try {
            return $this->pallet->get($request);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function qrShow($id)
    {
        try {
            return $this->pallet->qrShow($id);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function store(mixed $data)
    {
        try {
            return $this->pallet->store($data);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function edit($id)
    {
        try {
            return $this->pallet->edit($id);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    public function update(mixed $data, $id)
    {
        try {
            return $this->pallet->update($data,$id);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            return $this->pallet->destroy($id);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return false;
        }
    }
}
