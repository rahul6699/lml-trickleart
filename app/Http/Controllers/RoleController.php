<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;

class RoleController extends Controller
{


    public function __construct()
    {
        $this->head_title = 'Role';
        $this->module = 'role';
        $this->store_method = 'POST';
        $this->update_method = 'PUT';
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Role::select('*')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route("admin.$this->module.edit", $row->id);
                    $destroyRoute = route("admin.$this->module.destroy", $row->id);
                    $actionBtn = '<a href="javascript:void(0)" onclick="addItemModel(this, \'' . $editRoute . '\');" class="edit btn btn-success btn-sm"><ion-icon name="create-outline"></ion-icon></a> <a href="javascript:void(0)" onclick="deleteItem(this, \'' . $destroyRoute . '\');" class="delete btn btn-danger btn-sm"><ion-icon name="trash-outline"></ion-icon></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $createRoute = $formRoute = route("admin.$this->module.create");
        return view('roles.index', compact('createRoute'));
    }


    public function create()
    {
        $pageTitle = $this->head_title . " Add";
        $formRoute = route("admin.$this->module.store");
        $formMethod = $this->store_method;
        $view = View::make('roles.create', compact('pageTitle', 'formRoute', 'formMethod'))->render();
        return Response::json(['view' => $view]);
    }


    public function store(StoreRoleRequest $request)
    {
        Role::create(['name' => $request->name]);
        return Response::json(['success' => 'Role created successfully.']);
    }

    public function show(Role $role)
    {
        //
    }


    public function edit(Role $role)
    {
        $pageTitle = $this->head_title . " Edit";
        $formRoute = route("admin.$this->module.update", $role->id);
        $formMethod = $this->update_method;
        $formData = $role;
        $view = View::make('roles.edit', compact('pageTitle', 'formRoute', 'formMethod', 'formData'))->render();
        return Response::json(['view' => $view]);
    }


    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validatedData = $request->validated();
        $role->update($validatedData);
        return Response::json(['success' => 'Role updated successfully.']);
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return Response::json(['success' => 'Role deleted successfully.']);
    }
}
