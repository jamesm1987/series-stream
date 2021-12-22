<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $user = new User();

        $user->name = 'James';
        $user->email = 'jameskm1987@gmail.com';
        $user->password = Hash::make('Bamcafe91!');
        $user->current_team_id = 1;

        $user->save();

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_id' => 1,
            'model_type' => 'App\Models\User',
            'team_id' => 1
        ]);

        $role = Role::create([
            'name' => 'admin', 
            'team_id' => 1, 
            'guard_name' => 'web', 
            'created_at' => NOW(), 
            'updated_at' => NOW()
        ]);
        $user->assignRole($role);


    }
}
