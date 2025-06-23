<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PalletQrRequest;
use App\Service\Admin\PalletService;
use App\ServiceUtil\GenerateCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class PalletController extends Controller
{
    protected $pallet;

    /**
     * @param $pallet
     */
    public function __construct(PalletService $pallet)
    {
        $this->pallet = $pallet;
    }

    public function index()
    {
        return view('admin.pallet.index',[
            'title' => 'Pallet'
        ]);
    }

    public function get(Request $request)
    {

        if ($request->ajax()) {
            try{
                $data = $this->pallet->get($request);
                // Menyusun DataTables
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('code', function($row) {
                        $downloadqr = route('admin.pallet.qr.show', $row->id);
                        $btn = '<a href="'.$downloadqr.'" class="btn btn-outline-danger btn-xs" target="_blank"><i class="fa fa fa-qrcode" aria-hidden="true"></i> Show '.$row->code.'</a>';
                        return $btn;
                    })
                    ->addColumn('name', function($row) {
                        return $row->name;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div style="display: flex;gap: 6px">';
                        $btn .= '<a href="' . route('admin.pallet.edit', ['id' => $row->id]) . '" class="edit btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>';

                        $btn .= '<form action="' . route('admin.pallet.delete', $row->id) . '" method="POST" style="display:inline;" id="delete-form-visitor-' . $row->id . '">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" onclick="confirmDelete(\'' . $row->id . '\')" class="edit btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['name','action','code'])
                    ->make(true);
            }
            catch(Exception $exception){
                Log::error('exception',[$exception->getMessage()]);
                return false;
            }
        }
        abort(404);
    }

    public function qrshow($id)
    {
        $data = $this->pallet->qrShow($id);
        $writer = new PngWriter();

        // Create QR code
        $qrCode = new QrCode(
            data: $data->code,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        // Get the QR code as a base64-encoded string
        $qrCodeData = $writer->write($qrCode)->getString();
        $base64QrCode = base64_encode($qrCodeData);

        $dataArr = [
            'data' => $data,
            'qrCode' => $base64QrCode,
        ];

        // Load the view with the data
        $pdf = Pdf::loadView('admin.pallet.show', $dataArr);

        // Set the paper size to A6
        $pdf->setPaper('A4', 'portrait');

        // Preview the PDF (it will open in the browser)
        return $pdf->stream('pdf-preview.pdf');
    }

    public function create()
    {
        return view('admin.pallet.create',[
            'title' => 'Tambah Data Pallet'
        ]);
    }

    public function store(PalletQrRequest $request)
    {
        $data = $request->validated();
        $code = GenerateCode::pallet();
        if (!$code){
            return redirect()->back()->with(['error' => 'Code Generate Error.']);
        }
        $data['code'] = $code;
        $response = $this->pallet->store($data);
        if ($response){
            return redirect()->route('admin.pallet.index')->with(['success' => 'Success to Delete Data.']);
        }
        return redirect()->route('admin.pallet.index')->with(['error' => 'Failed to Delete Data.']);
    }

    public function edit($id)
    {
        $data = $this->pallet->edit($id);
        return view('admin.pallet.edit',[
            'title' => 'Edit Data Card Visitor',
            'id' => $id,
            'data' => $data
        ]);
    }

    public function update(PalletQrRequest $request,$id)
    {
        $data = $request->validated();
        $response = $this->pallet->update($data,$id);
        if ($response) {
            return redirect()->route('admin.pallet.index')->with('success', 'Success Update Data');
        }
        return redirect()->route('admin.pallet.index')->with('error', 'Failed Update Data');
    }

    public function destroy($id)
    {
        $response = $this->pallet->destroy($id);
        if ($response) {
            return redirect()->back()->with('success', 'Success Delete Data');
        }
        return redirect()->back()->with('error', 'Failed Delete Data');
    }
}
