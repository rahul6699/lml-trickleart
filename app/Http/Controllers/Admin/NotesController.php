<?php
           
namespace App\Http\Controllers\Admin;
            
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
                    ->addColumn('date', function($row){
                        $date = new Carbon($row->created_at);

                        return $date->format('d-m-Y');;

                    })
                    ->addColumn('action', function($row){
   
                    $btn = '<div class="d-flex gap-2">
                    <div class="view">
                        <button class="btn btn-sm btn-success edit-item-btn" onclick="editForm(this,`'.route('admin.note.show',$row->id).'`)">View</button>
                    </div>
                    <div class="edit">
                        <button class="btn btn-sm btn-success edit-item-btn" onclick="editForm(this,`'.route('admin.note.edit',$row->id).'`)">Edit</button>
                    </div>
                    <div class="remove">
                        <button class="btn btn-sm btn-danger remove-item-btn" onclick="deleteRow(this,`'.route('admin.note.destroy',$row->id).'`)">Remove</button>
                    </div>
                </div>';
    
                        return $btn;
                    })
                    ->rawColumns(['date','action'])
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
                    'title' => $request->title,
                    'note' => $request->note,
                ]);        
     
        return Response()->json(["status" => true,"data" => $Note,"message"=>"Note saved successfully."]);
    }
    

    public function edit($id)
    {
        $Note = Note::find($id);
        $view = view('admin.lead.note.edit', compact('Note'))->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    public function show($id)
    {
        $Note = Note::find($id);
        $view = view('admin.lead.note.view', compact('Note'))->render();
        return Response()->json(["status" => true,"view" => $view]);
    }
    
    
    public function destroy($id)
    {
        Note::find($id)->delete();
      
        return response()->json(['success'=>'Note deleted successfully.']);
    }
}