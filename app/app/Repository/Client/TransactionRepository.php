<?php

namespace App\Repository\Client;

use App\Models\DataPengiriman;
use App\Models\Inventori;
use App\Models\KebutuhanPengiriman;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TransactionRepository
{
    protected $dataPengiriman;
    protected $inventori;
    protected $kebutuhanKirim;

    /**
     * @param $transaction
     */
    public function __construct(DataPengiriman $dataPengiriman,Inventori $inventori,KebutuhanPengiriman $kebutuhanKirim)
    {
        $this->dataPengiriman = $dataPengiriman;
        $this->inventori = $inventori;
        $this->kebutuhanKirim = $kebutuhanKirim;
    }

    public function storeTransaction(array $data): bool
    {
        foreach ($data as $item) {
            $pengiriman = $this->dataPengiriman->create([
                'tanggal_pengiriman' => Carbon::parse($item['date'])->translatedFormat('d F Y'),
                'tujuan' => $item['location'],
            ]);

            if (!$pengiriman) {
                return false;
            }

            foreach ($item['data'] as $value) {
                $inventori = $this->inventori->where('OtherID', $value['kode'])->first();

                if (!$inventori) {
                    Log::warning("Inventori tidak ditemukan untuk kode: " . $value['kode']);
                    continue;
                }

                $result = $this->kebutuhanKirim->create([
                    'id_data_pengiriman' => $pengiriman->id,
                    'id_inventori' => $inventori->PartID,
                    'qty' => $value['jumlah'],
                ]);

                if (!$result) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getViewData($request)
    {
        $data = $this->dataPengiriman->newQuery()->whereNull('admin_confirmed');
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $searchTerm = $request->input('search')['value'];
            // 'tanggal_pengiriman', 'tujuan', 'expedisi', 'mulai', 'sampai',
            $data->where(function ($query) use ($searchTerm) {
                $query->where('data_pengiriman.tanggal_pengiriman', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('data_pengiriman.tujuan', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('data_pengiriman.expedisi', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('data_pengiriman.mulai', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('data_pengiriman.sampai', 'LIKE', "%{$searchTerm}%");
            });
        }

        if (!empty($request->input('order')[0]['column'])){
            switch($request->input('order')[0]['column']){
                case 1:
                    $data->orderBy('tanggal_pengiriman', $request->input('order')[0]['dir']);
                    break;
                case 2:
                    $data->orderBy('tujuan', $request->input('order')[0]['dir']);
                    break;
                case 3:
                    $data->orderBy('ekspedisi', $request->input('order')[0]['dir']);
                    break;
                case 4:
                    $data->orderBy('mulai', $request->input('order')[0]['dir']);
                    break;
                case 5:
                    $data->orderBy('sampai', $request->input('order')[0]['dir']);
                    break;
            }
        } else {
            $data->orderBy('updated_at', 'DESC');
        }
        return $data;
    }

    public function getDataByID($id)
    {
        return $this->dataPengiriman->where('id', $id)->firstOrFail();
    }

    public function updateData($data,$id)
    {
        return $this->dataPengiriman->where('id',$id)->update($data);
    }

    public function updateConfirmed($id)
    {
        return $this->dataPengiriman->where('id',$id)->update([
            'admin_confirmed' => Carbon::now()
        ]);
    }

    public function getKebutuhanByIDP($id_data_pengiriman)
    {
        return $this->kebutuhanKirim->with('inventori')->where('id_data_pengiriman', $id_data_pengiriman);
    }

    public function cekColumn($id)
    {
        return $this->dataPengiriman->where('id',$id)->whereNotNull('tujuan')
            ->whereNotNull('expedisi')
            ->whereNotNull('supir')
            ->whereNotNull('no_mobil')
            ->whereNotNull('no_loading')
            ->whereNotNull('no_cont')
            ->whereNotNull('mulai')
            ->whereNotNull('sampai')->lockForUpdate()
            ->firstOrFail();
    }
}
