<?php

namespace App\Repository\Client;

use App\Http\Resources\Checker3ResponseCollection;
use App\Models\DataPengiriman;
use App\Models\Pallet;
use App\Models\PalletCode;
use App\Models\PalletCustom;
use App\Models\TempPallet;
use Illuminate\Support\Carbon;

class Checker2Repository
{
    protected $dataPengiriman;
    protected $pallet;
    protected $palletCode;
    protected $tempPallet;
    protected $palletCustom;

    /**
     * @param $dataPengiriman
     */
    public function __construct(DataPengiriman $dataPengiriman,Pallet $pallet,PalletCode $palletCode,TempPallet $tempPallet,PalletCustom $palletCustom)
    {
        $this->dataPengiriman = $dataPengiriman;
        $this->pallet = $pallet;
        $this->palletCode = $palletCode;
        $this->tempPallet = $tempPallet;
        $this->palletCustom = $palletCustom;
    }

    public function get($request)
    {
        $data =  $this->dataPengiriman
            ->whereNotNull('checker1')->whereNotNull('checker2')->whereNull('checker3');

        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchTerm = $request->input('search')['value'];
            $data->where('tanggal_pengiriman', 'LIKE', "%{$searchTerm}%");
        }

        if (!empty($request->input('order')[0]['column']) && $request->input('order')[0]['column'] == 2){
            $data->orderBy('tanggal_pengiriman', $request->input('order')[0]['dir']);
        }else{
            $data->orderBy('updated_at', 'desc');
        }
        return $data;
    }

    public function getModal($id)
    {
        $data = $this->pallet->where('id_data_pengiriman',$id)->with('inventori','tempPallet.palletCode','palletCustom.inventori')->get();
        return $data;
    }

    public function update($cheker)
    {
        return $this->pallet->whereHas('tempPallet',function ($query) use ($cheker){
            $query->where('id_pallet_code',$cheker->id);
        })->update([
            'checker2' => Carbon::now()
        ]);
    }

    public function getPalletId($kode)
    {
        return $this->palletCode->where('code',$kode)->lockForUpdate()->firstOrFail();
    }

    public function getPalletByIdDataKirim(mixed $id)
    {
        return $this->pallet->where('id_data_pengiriman',$id)->lockForUpdate()->pluck('id');
    }

    public function updateDataKirim(mixed $id)
    {
        return $this->dataPengiriman->where('id',$id)->update([
           'checker3' => Carbon::now()
        ]);
    }

    public function deleteTemp($getPallet)
    {
        return $this->tempPallet->whereIn('id_pallet',$getPallet)->delete();
    }

    public function updateQtyCustom(mixed $data, $id)
    {
        return $this->palletCustom->where('id',$id)->update($data);
    }

    public function updateQtySingle($id)
    {
        return $this->pallet->where('id',$id)->delete();
    }

    public function destroyPalletSingle($id)
    {
        return $this->tempPallet->where('id_pallet',$id)->delete();
    }
}
