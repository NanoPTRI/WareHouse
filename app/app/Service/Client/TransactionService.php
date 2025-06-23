<?php

namespace App\Service\Client;

interface TransactionService
{
    public function storeTransaction(mixed $data);
    public function getViewData($request);
    public function getDataByID($id);
    public function updateData($data,$id);
    public function updateConfirmed($id);
    public function getKebutuhanByIDP($id_data_pengiriman);
}
