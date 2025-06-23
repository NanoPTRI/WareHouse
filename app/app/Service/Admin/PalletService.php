<?php

namespace App\Service\Admin;

interface PalletService
{
    public function get($request);
    public function qrShow($id);
    public function store(mixed $data);
    public function edit($id);
    public function update(mixed $data, $id);
    public function destroy($id);
}
