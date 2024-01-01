<?php
           
namespace App\Http\Controllers\Admin;
            
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
          
class NotesController extends Controller
{
    
    public function list(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Note::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            
                            <li><a href="javascript:void(0)" class="dropdown-item edit-item-btn" onclick="editForm(this,`'.route('admin.note.edit',$row->id).'`)"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                            <li>
                                <a href="javascript:void(0)" class="dropdown-item remove-item-btn" onclick="deleteRow(this,`'.route('admin.note.destroy',$row->id).'`)">
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
        $view = view('admin.lead.note.add')->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->validate();
        }

        $Note = Note::updateOrCreate([
                    'id' => $request->id
                ],
                [ 
                    'note' => $request->note
                ]);        
     
        return Response()->json(["status" => true,"data" => $Note,"message"=>"Note saved successfully."]);
    }
    

    public function edit($id)
    {
        $Note = Note::find($id);
        $view = view('admin.lead.note.edit', compact('Note'))->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    
    public function destroy($id)
    {
        Note::find($id)->delete();
      
        return response()->json(['success'=>'Note deleted successfully.']);
    }
}