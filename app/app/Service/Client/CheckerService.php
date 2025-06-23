<?php

namespace App\Service\Client;

interface CheckerService
{
    public function getDataPengiriman();
    public function getKebutuhanByIDP($id_data_pengiriman);
    public function updateChecker($id_data_pengiriman);
    public function getDataPrint();
}
