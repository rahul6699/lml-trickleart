<?php
           
namespace App\Http\Controllers\Admin;
            
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
          
class SettingsController extends Controller
{
       
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index',compact('settings'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'system_name' => 'required',
            'system_short_name' => 'required',
            'system_logo' => 'required|image',
        ]);

        if ($validator->fails()) {
            return $validator->validate();
        }

        $input = [
            'system_name' => $request->system_name, 
            'system_short_name' => $request->system_short_name
        ];
          
        if ($request->hasFile('system_logo')) {
            $avatarName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->system_logo->move(public_path('system_logo'), $avatarName);
  
            $input['system_logo'] = $avatarName;
        
        } else {
            unset($input['system_logo']);
        }

        $source = Setting::updateOrCreate([
                    'id' => $request->id
                ],
                $input);        
     
        return Response()->json(["status" => true,"data" => $source,"message"=>"Setting saved successfully."]);
    }
}