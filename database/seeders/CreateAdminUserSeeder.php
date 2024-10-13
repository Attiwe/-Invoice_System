<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء المستخدم أو استرجاعه إذا كان موجودًا
        $user = User::firstOrCreate([
            'email' => 'ebrahim@gmail.com',
        ], [
            'name' => 'ابراهيم سامي',
            'password' => bcrypt('123456'),
            'role_name' => json_encode(["owner"]),
            'Status' => 'مفعل',
        ]);

        // إنشاء الأدوار إذا لم تكن موجودة
        $roleOwner = Role::firstOrCreate(['name' => 'owner']);
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);
        
        // جلب جميع الأذونات
        $permissions = Permission::pluck('name')->all();  

        // إضافة الأذونات للدور owner
        if (!empty($permissions)) {
            $roleOwner->syncPermissions($permissions);
        }

        // تعيين الدور للمستخدم إذا لم يكن لديه
        if (!$user->hasRole('owner')) {
            $user->assignRole($roleOwner->name);
        }
    }
}
