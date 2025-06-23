<?php

namespace App\Service\Admin;

use App\Repository\Admin\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserServiceImpl implements UserService
{
    protected $user;

    /**
     * @param $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function store(mixed $data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            return $this->user->store($data);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return false;
        }
    }


    public function get($request)
    {
        try {
            return $this->user->get($request);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    public function getEmploye()
    {
        try {
            return $this->user->getEmploye();
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    public function edit($id)
    {
        try {
            return $this->user->edit($id);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    public function update(mixed $data, $id)
    {
        try {
            if(!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }else{
                unset($data['password']);
            }

            return $this->user->update($data, $id);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            return $this->user->destroy($id);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return false;
        }
    }
}
