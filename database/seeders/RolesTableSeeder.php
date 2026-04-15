<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['id' => 1], ['name' => 'superadmin']);
        Role::firstOrCreate(['id' => 2], ['name' => 'user']);
        Role::firstOrCreate(['id' => 3], ['name' => 'admin']);
    }
}