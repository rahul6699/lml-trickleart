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

                        $btn = '<div class="d-flex gap-2">
                            <div class="view">
                                <button class="btn btn-sm btn-success edit-item-btn" onclick="editForm(this,`'.route('admin.calllog.show',$row->id).'`)">View</button>
                            </div>
                            <div class="edit">
                                <button class="btn btn-sm btn-success edit-item-btn" onclick="editForm(this,`'.route('admin.calllog.edit',$row->id).'`)">Edit</button>
                            </div>
                            <div class="remove">
                                <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteRow(this,`'.route('admin.calllog.destroy',$row->id).'`)">Remove</button>
                            </div>
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
    
    public function show($id)
    {
        $CallLog = CallLog::find($id);
        $view = view('admin.lead.calllog.view', compact('CallLog'))->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    
    public function destroy($id)
    {
        CallLog::find($id)->delete();
      
        return response()->json(['success'=>'CallLog deleted successfully.']);
    }
}