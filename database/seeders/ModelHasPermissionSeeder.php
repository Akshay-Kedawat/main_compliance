<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\{Role,Permission};
use Illuminate\Database\Seeder;

class ModelHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::where('name', Role::ROLE_NAME['admin'])->first();
        $adminPermission = Permission::pluck('name')->toArray();
        $admin->syncPermissions($adminPermission); 
    }
}
