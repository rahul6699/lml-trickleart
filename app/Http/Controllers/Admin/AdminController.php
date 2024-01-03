<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function list(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Admin::latest()->where('id','!=',1)->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){
                        $label = '<span class="badge bg-danger-subtle text-danger text-uppercase">In-Active</span>';
                        if($row->status == 1){
                            $label ='<span class="badge bg-success-subtle text-success text-uppercase">Active</span>';
                        }
    
                        return $label;
                    })
                    ->addColumn('action', function($row){   

                        $btn = '<div class="d-flex gap-2">
                    <div class="edit">
                        <button class="btn btn-sm btn-success edit-item-btn" onclick="editForm(this,`'.route('admin.users.edit',$row->id).'`)">Edit</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteRow(this,`'.route('admin.users.destroy',$row->id).'`)">Remove</button>
                    </div>
                </div>';
                return $btn;
                    })
                    ->rawColumns(['status','action'])
                    ->make(true);
        }
    }
       
    public function create()
    {
        $view = view('admin.users.add')->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->validate();
        }
// echo "<pre>"; print_r($request->all());die;
        $admin = Admin::updateOrCreate([
                    'id' => $request->id
                ],
                [
                    'name' => $request->name, 
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' =>Hash::make($request->password),
                    'status' => $request->status
                ]);        
     
        return Response()->json(["status" => true,"data" => $admin,"message"=>"User saved successfully."]);
    }
    

    public function edit($id)
    {
        $admin = Admin::find($id);
        $view = view('admin.users.edit', compact('admin'))->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    
    public function destroy($id)
    {
        Admin::find($id)->delete();
      
        return response()->json(['success'=>'User deleted successfully.']);
    }
}
