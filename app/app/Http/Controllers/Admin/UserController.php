<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Service\Admin\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $user;

    /**
     * @param $user
     */
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('admin.user.index',[
           'title' => 'Users'
        ]);
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            try{
                $data = $this->user->get($request);
                // Menyusun DataTables
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('username', function($row) {
                        return $row->username;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div style="display: flex;gap: 6px">';
                        $btn .= '<a href="' . route('admin.user.edit', ['id' => $row->id]) . '" class="edit btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>';

                        $btn .= '<form action="' . route('admin.user.delete', $row->id) . '" method="POST" style="display:inline;" id="delete-form-visitor-' . $row->id . '">
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
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $response = $this->user->store($data);
        if ($response){
            return redirect()->route('admin.user.index')->with(['success' => 'Success to Create Data.']);
        }
        return redirect()->route('admin.user.index')->with(['error' => 'Failed to Create Data.']);
    }
    public function create()
    {
        $employe = $this->user->getEmploye();
        return view('admin.user.create',[
            'title' => 'Create User',
            'employes' => $employe,
        ]);
    }
    public function edit($id)
    {
        $data = $this->user->edit($id);
        $employe = $this->user->getEmploye();

        return view('admin.user.edit',[
            'title' => 'Add User',
            'data' => $data,
            'id' => $id,
            'employes' => $employe,
        ]);
    }

    public function update(UserUpdateRequest $request,$id)
    {
        $data = $request->validated();
        $response = $this->user->update($data,$id);
        if ($response){
            return redirect()->route('admin.user.index')->with(['success' => 'Success to Update Data.']);
        }
        return redirect()->route('admin.user.index')->with(['error' => 'Failed to Update Data.']);
    }
    public function destroy($id)
    {
        $response = $this->user->destroy($id);
        if ($response) {
            return redirect()->back()->with('success', 'Success Delete Data');
        }
        return redirect()->back()->with('error', 'Failed Delete Data');
    }

}
