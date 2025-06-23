<?php

namespace App\Repository\Admin;

use App\Models\Pallet;
use App\Models\PalletCode;

class PalletRepository
{
    protected $pallet;

    /**
     * @param $pallet
     */
    public function __construct(PalletCode $pallet)
    {
        $this->pallet = $pallet;
    }

    public function get($request)
    {
        $data =  $this->pallet->query();

        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchTerm = $request->input('search')['value'];
            $data->where('name', 'LIKE', "%{$searchTerm}%");
        }

        if (!empty($request->input('order')[0]['column']) && $request->input('order')[0]['column'] == 2){
            $data->orderBy('name', $request->input('order')[0]['dir']);
        }else{
            $data->orderBy('updated_at', 'desc');
        }
        return $data;
    }

    public function qrShow($id)
    {
        return $this->pallet->where('id',$id)->select('code')->firstOrFail();
    }

    public function store(mixed $data)
    {
        return $this->pallet->create($data);
    }

    public function edit($id)
    {
        return $this->pallet->where('id',$id)->select('id','name')->firstOrFail();
    }

    public function update(mixed $data, $id)
    {
        return $this->pallet->where('id',$id)->update($data);
    }

    public function destroy($id)
    {
        return $this->pallet->where('id',$id)->delete();
    }
}
