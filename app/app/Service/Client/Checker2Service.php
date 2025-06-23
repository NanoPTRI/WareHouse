<?php

namespace App\Service\Client;

interface Checker2Service
{
    public function get($request);
    public function getModal($id);
    public function update($kode);
    public function store(mixed $data);
    public function updateQtyCustom(mixed $data, $id);
    public function updateQtySingle($id);
}
