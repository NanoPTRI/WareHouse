<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinishChecker2Request;
use App\Http\Requests\UpdateQtyChecker3Request;
use App\Service\Client\Checker2Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class CheckerTwoController extends Controller
{
    protected $checker2;

    /**
     * @param $checker2
     */
    public function __construct(Checker2Service $checker2)
    {
        $this->checker2 = $checker2;
    }

    public function index()
    {
        return view('checkerthree.index',[
            'title' =>  'Checker 3'
        ]);
    }

    public function get(Request $request)
    {

        if ($request->ajax()) {
            try {
                $data = $this->checker2->get($request);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_pengiriman', function ($row) {
                        return $row->tanggal_pengiriman;
                    })
                    ->addColumn('tujuan', function ($row) {
                        return $row->tujuan;
                    })
                    ->addColumn('expedisi', function ($row) {
                        return $row->expedisi;
                    })
                    ->addColumn('mulai', function ($row) {
                        return $row->mulai;
                    })
                    ->addColumn('sampai', function ($row) {
                        return $row->sampai;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="#" onclick="modal(\'' . $row->id . '\', \'' . $row->tujuan . '\')" class="edit btn btn-outline-warning btn-sm" ><i class="fa fa-edit"></i></a>';
                        // $btn .= '<a href="' . route('edit.item', ['id' => $row->id]) . '" class="edit btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>';
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

    public function getModal(Request $request,$id)
    {

//        if ($request->ajax()) {
            $data = $this->checker2->getModal($id);
            return view('checkerthree.modal',[
                'id' => $id,
                'data' => $data
            ]);
//        }

//        abort(404);
    }

    public function update($kode)
    {
        $response = $this->checker2->update($kode);
        if ($response){
            return response()->json(['message' => 'Success Update Checker'], 201);
        }
        return response()->json(['message' => 'Failed Update Checker'], 500);

    }

    public function store(FinishChecker2Request $request)
    {
        $data = $request->validated();
        $response = $this->checker2->store($data);
        if ($response){
            return redirect()->back()->with(['success' => 'Success Finish Transaction']);
        }
        return response()->json(['message' => 'Failed Finish Transaction'], 500);
    }
    public function updateQtyCustom(UpdateQtyChecker3Request $request,$id)
    {
        $data = $request->validated();
        $response = $this->checker2->updateQtyCustom($data,$id);
        if ($response){
            return response()->json(['message' => 'Success Update Qty'], 201);
        }
        return response()->json(['message' => 'Failed Update Qty'], 500);
    }
    public function updateQtySingle($id)
    {
        $response = $this->checker2->updateQtySingle($id);
        if ($response){
            return response()->json(['message' => 'Success Delete Pallet'], 201);
        }
        return response()->json(['message' => 'Failed Delete Pallet'], 500);
    }

}
