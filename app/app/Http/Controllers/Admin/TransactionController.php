<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Service\Admin\AdminService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    protected $admin;

    /**
     * @param $admin
     */
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
    }

    public function index() {
        return view('admin.transaction.index', [
            'title' => "Transaction"
        ]);
    }

    public function get(Request $request,$date)
    {

        if ($request->ajax()) {
            try {
                $date = $date ?? now();
                $data = $this->admin->get($request,$date);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_pengiriman', function ($row) {
                        return \Carbon\Carbon::parse($row->tanggal_pengiriman)->translatedFormat('d F y');
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
                        $btn =  '<a href="#" onclick="showVisit(\'' . $row->id . '\')" id="sets" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modals-detail">
                                    <i class="fa fa-eye"></i>
                                </a>';
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

    public function getRunning(Request $request,$date)
    {

        if ($request->ajax()) {
            try {
                $date = $date ?? now();
                $data = $this->admin->getRunning($request,$date);

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_pengiriman', function ($row) {
                        return \Carbon\Carbon::parse($row->tanggal_pengiriman)->translatedFormat('d F y');
                    })
                    ->addColumn('tujuan', function ($row) {
                        return $row->tujuan;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="#" onclick="showDetail(\'' . $row->id . '\')" class="edit btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#modals-detail"><i class="fa fa-eye"></i></a>';
                        $btn .= '<a href="' . route('admin.transaction.edit', ['id' => $row->id]) . '" class="edit btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>';
                        $row->checker1 ??
                        $btn .= '<form action="' . route('admin.transaction.destroy',$row->id) . '" method="POST" style="display:inline;" id="delete-form-item-' . $row->id . '">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" onclick="confirmDelete(\'' . $row->id . '\')" class="edit btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>';
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     * id = id_data_pengiriman
     */
    public function show(Request $request,$id)
    {
        if ($request->ajax()) {
            $dataPallet = $this->admin->dataPallet($id);
            $qtyPlan = $this->admin->qtyPlan($id)->keyBy('id_inventori');
            $inventori = $this->admin->inventori($id);

            $data = $this->admin->show($id);
            $maxGroup = $dataPallet->sortByDesc(function ($items) {
                return $items;
            })->first();
            return view('admin.transaction.show', [
                'title' => 'Detail Transaction',
                'data' => $data,
                'pallet' => $dataPallet,
                'qtyPlan' => $qtyPlan,
                'inventori' => $inventori,
                'maxGroup' => count($maxGroup)
            ]);
        }
        abort(404);
    }

    public function running()
    {
        return view('admin.transaction.running', [
            'title' => "Transaction Running"
        ]);
    }

    public function destroy($id)
    {
        $response = $this->admin->destroy($id);
        if ($response){
            return redirect()->back()->with(['success' => 'Success to Delete Data.']);

        }
        return redirect()->back()->with(['error' => 'Failed to Delete Data.']);
    }

    public function print($id)
    {
        $dataPallet = $this->admin->dataPallet($id);
        $qtyPlan = $this->admin->qtyPlan($id)->keyBy('id_inventori');
        $inventori = $this->admin->inventori($id);

        $data = $this->admin->show($id);
        $maxGroup = $dataPallet->sortByDesc(function ($items) {
            return $items;
        })->first();
        return view('admin.transaction.print',[
            'title' => 'Detail Transaction',
            'data' => $data,
            'pallet' => $dataPallet,
            'qtyPlan' => $qtyPlan,
            'inventori' => $inventori,
            'maxGroup' => count($maxGroup)
        ]);
    }

    public function edit($id)
    {
        $data = $this->admin->getDataByID($id);
        return view('admin.transaction.edit', [
            'title' => "Edit Data Planning",
            'transaction' => $data,
        ]);
    }

    public function update(TransactionRequest $request, $id)
    {
        $data = $request->validated();

        $response = $this->admin->updateData($data,$id);
        if ($response){
            return redirect()->route('admin.transaction.running')->with('success', 'Data Planning updated successfully!');
        }
        return redirect()->back()->withErrors(['error' => 'Failed to update Data Planning Please try again.'])->withInput();
    }

    public function detail($id)
    {
        $response = $this->admin->getDataById($id);
        return view('admin.transaction.detail',[
            'title' => 'Detail Data Planning',
            'data' => $response,
            'id_data_pengiriman' => $id,
        ]);
    }

    public function getDetailData(Request $request, $id_data_pengiriman)
    {

        if ($request->ajax()) {
            try {
                $data = $this->admin->getKebutuhanByIDP($id_data_pengiriman);
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
