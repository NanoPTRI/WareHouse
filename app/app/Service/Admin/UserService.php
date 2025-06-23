<?php

namespace App\Service\Admin;

interface UserService
{
    public function store(mixed $data);
    public function get($request);
    public function getEmploye();
    public function edit($id);
    public function update(mixed $data, $id);
    public function destroy($id);
}
