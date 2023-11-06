<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manage = new Permission();
        $manage->name = 'Admin';
        $manage->slug = 'manege_admin';
        $manage->save();
        $manageOwner = new Permission();
        $manageOwner->name = 'Manage owner';
        $manageOwner->slug = 'manage_owner';
        $manageOwner->save();
    }
}
