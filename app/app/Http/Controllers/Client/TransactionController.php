<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use Exception;
use App\Models\Inventori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ExcelStoreRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionRequest;
use App\Service\Client\TransactionService;

class TransactionController extends Controller
{
    protected $transaction;

    /**
     * @param $transaction
     */
    public function __construct(TransactionService $transaction)
    {
        $this->transaction = $transaction;
    }

    public function index() {

        return view('transaction.index', [
            'title' => "Upload Data Planning"
        ]);
    }

    public function store(ExcelStoreRequest $request)
    {
        $file = $request->file('file');

        $response = Http::attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post('http://localhost:8383/pellet-excel');

        $data= $response->json();

        $data= json_decode($data, true);
        if ($response->successful()) {
            session(['imported_excel_data' => $data]);
            return redirect()->back();
        }

        return response()->json(['error' => 'Gagal mengirim file'], 500);
    }

    public function getTable(Request $request)
    {
        if ($request->ajax()) {
            $data = session('imported_excel_data');
            if ($data){
                return response()->json($data);
            }
            return response()->json([
                'error' => 'data not found'
            ],404);

        }

        abort(403);
    }

    public function storeTransaction()
    {
        $data = Session::get('imported_excel_data');
        if (!$data){
            Log::error('Data Kosong');
            return redirect()->back()->with(['error' => 'Data Tidak Boleh Kosong']);

        }
        $response = $this->transaction->storeTransaction($data);

        if ($response) {
            session()->forget('imported_excel_data');

            return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
        } else {
            return redirect()->back()->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function view()
    {
        return view('transaction.view', [
            'title' => "Data Planning"
        ]);
    }

    public function getViewData(Request $request)
    {

        if ($request->ajax()) {
            try {
                $data = $this->transaction->getViewData($request);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_pengiriman', function ($row) {
                        return Carbon::parse($row->tanggal_pengiriman)->translatedFormat('j F Y');
                    })

                    ->addColumn('detail', function ($row) {
                        $btn = '<a href="#" onclick="showDetail(\'' . $row->id . '\')" id="sets" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modals-detail">
                                <i class="fa fa-sticky-note"></i></a>';
                        return $btn;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="row" style="gap: 4px;">';
                        $btn .= '<a href="' . route('transaction.edit', ['id' => $row->id]) . '" class="edit btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>';
                        $btn .= '<form action="' . route('transaction.finish', $row->id) . '" method="POST" style="display:inline;" id="finish-plan-' . $row->id . '">'
                            . csrf_field()
                            . '<button type="button" onclick="confirmUpdate(\'' . $row->id . '\')" class="edit btn btn-outline-danger btn-sm"><i class="fa fa-save"></i></button>'
                            . '</form>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['tanggal_pengiriman', 'detail', 'action'])
                    ->make(true);

            } catch (Exception $exception) {
                Log::error('exception', [$exception->getMessage()]);
                return response()->json(['error' => 'DataTables processing failed.'], 500);
            }
        }
        abort(404);
    }

    public function edit($id)
    {
        $data = $this->transaction->getDataByID($id);
        return view('transaction.edit', [
            'title' => "Edit Data Planning",
            'transaction' => $data,
        ]);
    }

    public function update(TransactionRequest $request, $id)
    {
        $data = $request->validated();

        $response = $this->transaction->updateData($data,$id);
        if ($response){
            return redirect()->route('transaction.view')->with('success', 'Data Planning updated successfully!');
        }
        return redirect()->back()->withErrors(['error' => 'Failed to update Data Planning Please try again.'])->withInput();
    }

    public function show($id)
    {
        $response = $this->transaction->getDataById($id);
        return view('transaction.show',[
            'title' => 'Detail Data Planning',
            'data' => $response,
            'id_data_pengiriman' => $id,
        ]);
    }

    public function updateConfirmed($id)
    {
        $response = $this->transaction->updateConfirmed($id);
        if ($response){
            return redirect()->route('transaction.view')->with('success', 'Data Planning finished!');
        }
        return redirect()->back()->with(['error' => 'Failed to finish Data Planning Cek Input First.']);
    }

    public function getShowData(Request $request, $id_data_pengiriman)
    {

        if ($request->ajax()) {
            try {
                $data = $this->transaction->getKebutuhanByIDP($id_data_pengiriman);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('other_id', function ($row) {
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
}
