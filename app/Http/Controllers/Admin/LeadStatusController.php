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
                    ->editColumn('status', function($row){
                        $label = "In-active";
                        if($row->status == 1){
                            $label = "Active";
                        }
    
                            return $label;
                    })
                    ->addColumn('action', function($row){
   
                        $btn = '<div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            
                            <li><a href="javascript:void(0)" class="dropdown-item edit-item-btn" onclick="editForm(this,`'.route('admin.source.edit',$row->id).'`)"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                            <li>
                                <a href="javascript:void(0)" class="dropdown-item remove-item-btn" onclick="deleteRow(this,`'.route('admin.source.destroy',$row->id).'`)">
                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
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