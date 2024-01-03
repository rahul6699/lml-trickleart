<?php
           
namespace App\Http\Controllers\Admin;
            
use App\Http\Controllers\Controller;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
          
class LeadStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lead_status.index');
    }

    public function list(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = LeadStatus::latest()->get();
  
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
                                <button class="btn btn-sm btn-success edit-item-btn" onclick="editForm(this,`'.route('admin.lead_status.edit',$row->id).'`)">Edit</button>
                            </div>
                            <div class="remove">
                                <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteRow(this,`'.route('admin.lead_status.destroy',$row->id).'`)">Remove</button>
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
        $view = view('admin.lead_status.add')->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->validate();
        }

        $source = LeadStatus::updateOrCreate([
                    'id' => $request->id
                ],
                [
                    'name' => $request->name, 
                    'status' => $request->status
                ]);        
     
        return Response()->json(["status" => true,"data" => $source,"message"=>"Lead Status saved successfully."]);
    }
    

    public function edit($id)
    {
        $source = LeadStatus::find($id);
        $view = view('admin.lead_status.edit', compact('source'))->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    
    public function destroy($id)
    {
        LeadStatus::find($id)->delete();
      
        return response()->json(['success'=>'Lead Status deleted successfully.']);
    }
}