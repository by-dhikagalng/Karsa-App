<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@karsa.test'],
            ['name' => 'Super Admin', 'password' => 'password_superAdmin', 'role' => 'super_admin', 'organization_id' => null]
        );

        foreach (Organization::all() as $organization) {
            User::updateOrCreate(
                ['email' => Str::slug($organization->name) . '@karsa.test'],
                ['name' => 'Admin ' . $organization->name, 'password' => 'password', 'role' => 'admin_ormawa', 'organization_id' => $organization->id]
            );
        }
    }
}
