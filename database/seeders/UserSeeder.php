<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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

        $role = Role::create(['name' => 'Super-Admin']);
        $user->assignRole($role);


    }
}
