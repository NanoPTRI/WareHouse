<?php

namespace App\Service\Admin;

interface AdminService
{
    public function get($request,$date);
    public function show($id);
    public function dataPallet($id);
    public function inventori($id);
    public function destroy($id);
    public function getRunning($request,$date);
    public function getDataByID($id);
    public function updateData($data,$id);
    public function getKebutuhanByIDP($id_data_pengiriman);
    public function qtyPlan($id);
}
