<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $superadminRoleId = Role::where('name', 'superadmin')->value('id');

        if (!$superadminRoleId) {
            $this->command->error('Superadmin role does not exist. Run RolesTableSeeder first.');
            return;
        }

        $exists = User::where('role_id', $superadminRoleId)->exists();
        if ($exists) {
            $this->command->info('Superadmin already exists. Skipping...');
            return;
        }

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com', 
            'password' => Hash::make('password123'), 
            'gender' => 'male', 
            'avatar' => 'storage/avatar/male.jpg', 
            'role_id' => $superadminRoleId,
        ]);

        $this->command->info('Superadmin created successfully!');
    }
}