<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checker1Request;
use Yajra\DataTables\Facades\DataTables;
use App\Service\Client\Checker1Service;

class CheckerOneController extends Controller
{
    protected $checkerone;

    /**
     * @param $transaction
     */
    public function __construct(Checker1Service $checkerone)
    {
        $this->checkerone = $checkerone;
    }

    public function index() {
        $data['title'] = "Data Checker 2";
        return view('checkertwo.index', $data);
    }

    public function getDataKebutuhan(Request $request, $id_data_pengiriman)
    {
        if ($request->ajax()) {
            try {
                $data = $this->checkerone->getKebutuhanByIDP($id_data_pengiriman);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('type', function ($row) {
                        return $row->inventori->OtherID;
                    })
                    ->addColumn('qty', function ($row) {
                        return $row->qty;
                    })

                    ->rawColumns(['other_id', 'qty'])
                    ->make(true);

            } catch (Exception $exception) {
                Log::error('exception', [$exception->getMessage()]);
                return response()->json(['error' => 'DataTables processing failed.'], 500);
            }
        }
        abort(404);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = $this->checkerone->getData($request);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_pengiriman', function ($row) {
                        return Carbon::parse($row->tanggal_pengiriman)->translatedFormat('j F Y');
                    })
                    ->addColumn('tujuan', function ($row) {
                        return $row->tujuan;
                    })
                    ->addColumn('expedisi', function ($row) {
                        return $row->expedisi;
                    })
                    ->addColumn('mulai', function ($row) {
                        return Carbon::parse($row->mulai)->format('H:i');
                    })
                    ->addColumn('sampai', function ($row) {
                        return Carbon::parse($row->sampai)->format('H:i');
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="#" onclick="showDetail(\'' . $row->id . '\')" class="edit btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#modals-detail"><i class="fa fa-eye"></i></a>';
                        $btn .= '<a class="edit btn btn-outline-warning btn-sm mr-1" onclick="addNew(\''.$row->id.'\', \''.$row->tujuan.'\')"><i class="fa fa-plus"></i></a>';
                        $btn .= '<form action="' . route('checkertwo.store.checker', $row->id) . '" method="POST" style="display:inline;" id="update-form-item-' . $row->id . '">'
                            . csrf_field()
                            . '<button type="button" onclick="confirmUpdate(\'' . $row->id . '\')" class="edit btn btn-outline-danger btn-sm"><i class="fa fa-save"></i></button>'
                            . '</form>';
                        return $btn;
                    })
                    ->rawColumns(['tanggal_pengiriman', 'tujuan', 'expedisi', 'mulai', 'sampai', 'action'])
                    ->make(true);

            } catch (Exception $exception) {
                Log::error('exception', [$exception->getMessage()]);
                return response()->json(['error' => 'DataTables processing failed.'], 500);
            }
        }
        abort(404);
    }

    public function store(Checker1Request $request) {
        $request = $request->validated();
        $response = $this->checkerone->store($request);
        if ($response){
            return response()->json(['message' => 'Success Add Pallet'], 201);
        }
        return response()->json(['message' => 'Failed Add Pallet'], 400);
    }


    public function getShowData(Request $request, $id_data_pengiriman)
    {
        if ($request->ajax()) {
            $dataPallet = $this->checkerone->dataPallet($id_data_pengiriman);

            $qtyPlan = $this->checkerone->qtyPlan($id_data_pengiriman);

            $inventori = $this->checkerone->inventori($qtyPlan->pluck('id_inventori'));

            $maxGroup = $dataPallet->sortByDesc(function ($items) {
                return $items;
            })->first();
            return view('checkertwo.show', [
                'title' => 'Detail Transaction',
                'pallet' => $dataPallet,
                'qtyPlan' => $qtyPlan->keyBy('id_inventori'),
                'inventori' => $inventori,
                'maxGroup' => isset($maxGroup) ? count($maxGroup) : 0
            ]);
        }
        abort(404);
    }

    public function checkPallet($kode)
    {
        $response = $this->checkerone->checkPallet($kode);

        if ($response){
            return response()->json(['message' => 'Pallet Is Ready'], 200);
        }
        return response()->json(['message' => 'Please Scan Other Pallet Cause Its Not Ready'], 404);
    }

    public function checkItem($kode,$qty,$id_data_pengiriman)
    {
        $response = $this->checkerone->checkItem($kode,$qty,$id_data_pengiriman);

        if ($response){
            return response()->json($response, 200);
        }
        return response()->json(['message' => 'Please Scan Other Item Cause Its Not Ready'], 404);
    }

    public function destroyPallet($id)
    {
        $response = $this->checkerone->destroyPallet($id);
        if ($response){
            return redirect()->back()->with('success','success delete pallet');
        }
        return redirect()->back()->with('error','Failed delete pallet');
    }

    public function updateChecker($id)
    {
        $response = $this->checkerone->updateChecker($id);
        if ($response){
            return redirect()->back()->with('success','Success Finish Pallet');
        }
        return redirect()->back()->with('error','Failed Finish Pallet');
    }
}
