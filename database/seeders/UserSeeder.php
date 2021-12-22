<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;


use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'access admin']);
        
        $role = Role::create([
            'name' => 'admin', 
            'guard_name' => 'web', 
            'created_at' => NOW(), 
            'updated_at' => NOW()
        ]);


        $user = new User();

        $user->name = 'James';
        $user->email = 'jameskm1987@gmail.com';
        $user->password = Hash::make('Bamcafe91!');

        $user->save();
        
        $user->assignRole($role);
        
        


    }
}
