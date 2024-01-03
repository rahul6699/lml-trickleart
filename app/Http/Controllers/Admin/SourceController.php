<?php
           
namespace App\Http\Controllers\Admin;
            
use App\Http\Controllers\Controller;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
          
class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.source.index');
    }

    public function list(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Source::latest()->get();
  
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
                        <button class="btn btn-sm btn-success edit-item-btn" onclick="editForm(this,`'.route('admin.source.edit',$row->id).'`)">Edit</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteRow(this,`'.route('admin.source.destroy',$row->id).'`)">Remove</button>
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
        $view = view('admin.source.add')->render();
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

        $source = Source::updateOrCreate([
                    'id' => $request->id
                ],
                [
                    'name' => $request->name, 
                    'description' => $request->description,
                    'status' => $request->status
                ]);        
     
        return Response()->json(["status" => true,"data" => $source,"message"=>"Source saved successfully."]);
    }
    

    public function edit($id)
    {
        $source = Source::find($id);
        $view = view('admin.source.edit', compact('source'))->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    
    public function destroy($id)
    {
        Source::find($id)->delete();
      
        return response()->json(['success'=>'Source deleted successfully.']);
    }
}