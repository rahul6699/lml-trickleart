<?php
           
namespace App\Http\Controllers\Admin;
            
use App\Http\Controllers\Controller;
use App\Models\{Lead,Source,LeadStatus,Client};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
          
class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lead.index');
    }

    public function list(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Lead::latest()->get();
            // echo "<pre>"; print_r($data);die;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('name', function($row){
                        return $row->Client->name;
                    })
                    ->editColumn('contact_no', function($row){
                        return $row->Client->contact_no;
                    })
                    ->editColumn('whatsapp_no', function($row){
                        return $row->Client->whatsapp_no;
                    })
                    ->editColumn('lead_source', function($row){
                        return $row->Source->name;
                    })
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
                            <li><a href="'.route('admin.leads.show',$row->id).'" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                            <li><a class="dropdown-item edit-item-btn" href="'.route('admin.leads.edit',$row->id).'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
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
        $source =  Source::where('status',1)->get();
        $leadStatus =  LeadStatus::where('status',1)->get();
        return view('admin.lead.add',compact('source','leadStatus'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'contact_no' => 'required',
            'whatsapp_no' => 'required',
            'address' => 'required',
            'interested_in' => 'required',
            'source_id' => 'required',
            'remark' => 'required',
            'lead_status_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->validate();
        }

        $client = Client::updateOrCreate([
                    'id' => $request->id
                ],
                [
                    'name' => $request->name, 
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'contact_no' => $request->contact_no,
                    'whatsapp_no' => $request->whatsapp_no,
                    'address' => $request->address,
                    'status' => 1,
                ]);        
        $lead = Lead::updateOrCreate([
                    'client_id' => $client->id
                ],
                [
                    'interested_in' => $request->interested_in, 
                    'source_id' => $request->source_id,
                    'lead_status_id' => $request->lead_status_id,
                    'remark' => $request->remark,
                    'status' => 1,
                ]);        
     
        return Response()->json(["status" => true,"data" => compact('client','lead'),"message"=>"Lead saved successfully."]);
    }
    

    public function edit($id)
    {
        $source =  Source::where('status',1)->get();
        $leadStatus =  LeadStatus::where('status',1)->get();
        $lead = Lead::find($id);
        return view('admin.lead.edit', compact('lead','leadStatus','source'));
    }
    
    public function show($id)
    {
        $source =  Source::where('status',1)->get();
        $leadStatus =  LeadStatus::where('status',1)->get();
        $lead = Lead::find($id);
        return view('admin.lead.view', compact('lead','leadStatus','source'));
    }
    
    public function tabInfo(Request $request)
    {
        $source =  Source::where('status',1)->get();
        $leadStatus =  LeadStatus::where('status',1)->get();
        $lead = Lead::find($request->id);
        if($request->type=='information'){
            $view = view('admin.lead.tabinfo', compact('lead','leadStatus','source'))->render();
        }else if($request->type=='calllog'){
            $view = view('admin.lead.calllog.index', compact('lead','leadStatus','source'))->render();
        }else if($request->type=='notes'){
            $view = view('admin.lead.note.index', compact('lead','leadStatus','source'))->render();
        }
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    
    public function destroy($id)
    {
        Lead::find($id)->delete();
      
        return response()->json(['success'=>'Lead deleted successfully.']);
    }
}