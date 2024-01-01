<?php
           
namespace App\Http\Controllers\Admin;
            
use App\Http\Controllers\Controller;
use App\Models\CallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
          
class CallLogsController extends Controller
{
    

    public function list(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = CallLog::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            
                            <li><a href="javascript:void(0)" class="dropdown-item edit-item-btn" onclick="editForm(this,`'.route('admin.calllog.edit',$row->id).'`)"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                            <li>
                                <a href="javascript:void(0)" class="dropdown-item remove-item-btn" onclick="deleteRow(this,`'.route('admin.calllog.destroy',$row->id).'`)">
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
        $view = view('admin.lead.calllog.add')->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'log_type' => 'required',
            'remark' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->validate();
        }

        $CallLog = CallLog::updateOrCreate([
                    'id' => $request->id
                ],
                [
                    'log_type' => $request->log_type, 
                    'remark' => $request->remark,
                    'status' => $request->status
                ]);        
     
        return Response()->json(["status" => true,"data" => $CallLog,"message"=>"CallLog saved successfully."]);
    }
    

    public function edit($id)
    {
        $CallLog = CallLog::find($id);
        $view = view('admin.lead.calllog.edit', compact('CallLog'))->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    
    public function destroy($id)
    {
        CallLog::find($id)->delete();
      
        return response()->json(['success'=>'CallLog deleted successfully.']);
    }
}