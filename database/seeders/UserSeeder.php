<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('slug','admin')->first();
        $manegeAdmin = Permission::where('slug','manege_admin')->first();
        $admin = User::factory()->create([
            'name'=>'admin',
            'email' => 'admin@i.ua',
        ]);
        $admin->roles()->attach($adminRole);
        $admin->permissions()->attach($manegeAdmin);
        $authRole = Role::where('slug','auth')->first();
        $manegeAuth = Permission::where('slug','manage_owner')->first();
        $auth = User::factory()->create([
            'name'=>'auth',
            'email' => 'auth@i.ua',
        ]);
        $auth->roles()->attach($authRole);
        $auth->permissions()->attach($manegeAuth);
    }
}
