<?php

namespace App\Repository\Admin;

use App\Models\Employe;
use App\Models\User;

class UserRepository
{
    protected $user;
    protected $employe;

    /**
     * @param $user
     */
    public function __construct(User $user,Employe $employe)
    {
        $this->user = $user;
        $this->employe = $employe;
    }

    public function store(mixed $data)
    {
        return $this->user->create($data);
    }

    public function get($request)
    {
        $data =  $this->user->query();

        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchTerm = $request->input('search')['value'];
            $data->where('username', 'LIKE', "%{$searchTerm}%");
        }

        if (!empty($request->input('order')[0]['column']) && $request->input('order')[0]['column'] == 2){
            $data->orderBy('username', $request->input('order')[0]['dir']);
        }else{
            $data->orderBy('updated_at', 'desc');
        }
        return $data;
    }

    public function getEmploye()
    {
        return $this->employe->get();
    }

    public function edit($id)
    {
        return $this->user->where('id',$id)->firstOrFail();
    }

    public function update(mixed $data, $id)
    {
        return $this->user->where('id',$id)->update($data);

    }

    public function destroy($id)
    {
        return $this->user->where('id',$id)->delete();
    }
}
