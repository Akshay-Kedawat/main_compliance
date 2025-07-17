<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use Helpers;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = Helpers::crrrentDateTime();

        $permissions = [
            ['name' => config('constant.add-user'), 'guard_name' => 'web', 'group'=>config('constant.user-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => config('constant.edit-user'), 'guard_name' => 'web', 'group'=>config('constant.user-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => config('constant.delete-user'), 'guard_name' => 'web', 'group'=>config('constant.user-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => config('constant.list-user'), 'guard_name' => 'web', 'group'=>config('constant.user-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],

            ['name' => config('constant.add-category'), 'guard_name' => 'web', 'group'=>config('constant.category-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => config('constant.edit-category'), 'guard_name' => 'web', 'group'=>config('constant.category-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => config('constant.delete-category'), 'guard_name' => 'web', 'group'=>config('constant.category-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => config('constant.list-category'), 'guard_name' => 'web', 'group'=>config('constant.category-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
            
            
            ['name' => config('constant.list-role'), 'guard_name' => 'web', 'group'=>config('constant.role-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => config('constant.assign-permission'), 'guard_name' => 'web', 'group'=>config('constant.role-group'), 'created_at' => $currentDate, 'updated_at' => $currentDate],
        ];
        Permission::insert($permissions);
    }
}
