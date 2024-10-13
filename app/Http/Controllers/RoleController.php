<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
    //     $this->middleware('permission:اضافة صلاحية', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:تعديل صلاحية', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    // }

    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permissions = Permission::all();
         return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
         $role = Role::create(['name' => $request->input('name')]);
    
         $permissions = Permission::whereIn('id', $request->input('permission'))->get();
    
         $role->syncPermissions($permissions);
    
         return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }
    
    
    public function update(Request $request, $id)
    {
         $role = Role::findOrFail($id);
    
         $role->name = $request->input('name');
        $role->save();
    
         $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name')->toArray();
    
         $role->syncPermissions($permissions);
    
         return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }
    
    

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $id)
            ->pluck('permission_id', 'permission_id')
            ->all();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

     public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
