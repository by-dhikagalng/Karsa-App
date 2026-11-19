<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::create([
            'name' => 'KSM Veterantech',
            'type' => 'KSM',
        ]);

        Organization::create([
            'name' => 'KSM Multimedia',
            'type' => 'KSM',
        ]);

        Organization::create([
            'name' => 'KSM CyberSecurity',
            'type' => 'KSM',
        ]);

        Organization::create([
            'name' => 'KSM IOT',
            'type' => 'KSM',
        ]);

        Organization::create([
            'name' => 'BEM-Fik',
            'type' => 'Ormawa',
        ]);

        Organization::create([
            'name' => 'HIMA S1 Sistem Informasi',
            'type' => 'Ormawa',
        ]);

        Organization::create([
            'name' => 'HIMA Informatika',
            'type' => 'Ormawa',
        ]);

        Organization::create([
            'name' => 'HIMA D3 Sistem Informasi',
            'type' => 'Ormawa',
        ]);

    }
}
