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