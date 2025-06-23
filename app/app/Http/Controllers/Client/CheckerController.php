<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Service\Client\CheckerService;

class CheckerController extends Controller
{
    protected $checker;

    /**
     * @param $transaction
     */
    public function __construct(CheckerService $checker)
    {
        $this->checker = $checker;
    }

    public function index() {
        $dataPengiriman = $this->checker->getDataPengiriman();
        return view('checker.index', [
            'title' => "Data Checker 1",
            'dataPengiriman' => $dataPengiriman
        ]);
    }

    public function getData(Request $request, $id_data_pengiriman)
    {
        if ($request->ajax()) {
            try {
                $data = $this->checker->getKebutuhanByIDP($id_data_pengiriman);
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

    public function updateChecker($id_data_pengiriman)
    {
        $response = $this->checker->updateChecker($id_data_pengiriman);
        if ($response){
            return redirect()->route('checker.index')->with('success', 'Data Planning finished!');
        }
        return redirect()->back()->withErrors(['error' => 'Failed to finish Data Planning.']);
    }

    public function print()
    {
        $dataPengiriman = $this->checker->getDataPrint();
        return view('checker.print', [
            'title' => "Data Checker 1",
            'dataPengiriman' => $dataPengiriman
        ]);
    }
}
