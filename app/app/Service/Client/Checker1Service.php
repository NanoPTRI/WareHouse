<?php

namespace App\Service\Client;

interface Checker1Service
{
    public function getData($request);
    public function store($request);
    public function checkPallet($kode);
    public function getDataByIDP($id_data_pengiriman);
    public function getCustomOtherIDs($id);
    public function getCustomQty($id);
    public function checkItem($kode,$qty,$id_data_pengiriman);
    public function destroyPallet($id);
    public function updateChecker($id);
    public function getKebutuhanByIDP($id_data_pengiriman);

    public function dataPallet($id_data_pengiriman);
    public function qtyPlan($id_data_pengiriman);
    public function inventori($idinventori);
}
