<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\{User,Role};

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('email', 'admin@gmail.com')->delete();
        User::create([
            'name'          => 'admin',
            'email'         => 'admin@gmail.com',
            'password'      => Hash::make('Test@123'),
            'status'        => User::STATUS['Active']
        ])->assignRole(Role::ROLE_NAME['admin']);
    }

}
