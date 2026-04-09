<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(['id' => 1], ['name' => 'superadmin']);
        Role::updateOrCreate(['id' => 2], ['name' => 'user']);
        Role::updateOrCreate(['id' => 3], ['name' => 'admin']);
    }
}