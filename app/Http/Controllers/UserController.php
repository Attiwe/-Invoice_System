<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
 use Illuminate\Support\Arr;


class UserController extends Controller
{
    // عرض قائمة المستخدمين
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.show_users', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
    $roles = Role::pluck('name','name')->all();
    
    return view('users.Add_user',compact('roles'));
    
    }

    // تخزين المستخدم الجديد
    public function store(Request $request)  
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'role_name' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success','تم اضافة المستخدم بنجاح');;
    }

     public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

     public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    //  public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email,' . $id,
    //         'password' => 'same:confirm-password',
    //         'role_name' => 'required',
    //     ]);

    //     $input = $request->all();
        
    //     if (!empty($input['password'])) {
    //         $input['password'] = Hash::make($input['password']);
    //     } else {
    //         unset($input['password']);
    //     }

    //     $user = User::find($id);
    //     $user->update($input);
        
    //     DB::table('model_has_roles')->where('model_id', $id)->delete();
    //     $user->assignRole($request->input('roles'));

    //     return redirect()->route('users.index');
    // }
    // use Illuminate\Support\Arr;
    // use Illuminate\Support\Facades\Hash;
    // use App\Models\User;
    // use DB;
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
        ]);
    
        $input = $request->all();
    
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            // استبدال array_except بـ Arr::except
            $input = Arr::except($input, ['password']);
        }
    
        $user = User::find($id);
        $user->update($input);
    
        // حذف الأدوار القديمة
        DB::table('model_has_roles')->where('model_id', $id)->delete();
    
        // تعيين الأدوار الجديدة
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
            ->with('success', 'تم تحديث معلومات المستخدم بنجاح');
    }
    
     public function destroy(Request $request)
    {
        User::find($request->user_id)->delete();
        return redirect()->route('users.index')->with('success','تم حذف المستخدم بنجاح');
    }
}
