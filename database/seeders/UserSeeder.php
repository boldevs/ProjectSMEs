<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(['name' => 'super-admin'],['name' => 'super-admin']);
        Role::updateOrCreate(['name' => 'normal-user'],['name' => 'normal-user']);

        $user = User::updateOrCreate(
            ['name' => 'Admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('P@ssw0rd')
            ]
        );

        $user->assignRole(Role::all());
    }
}
