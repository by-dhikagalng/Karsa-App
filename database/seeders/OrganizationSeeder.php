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
        $organizations = [
            ['KSM Veterantech', 'KSM'],
            ['KSM Multimedia', 'KSM'],
            ['KSM CyberSecurity', 'KSM'],
            ['KSM IOT', 'KSM'],
            ['BEM-Fik', 'Ormawa'],
            ['HIMA S1 Sistem Informasi', 'Ormawa'],
            ['HIMA Informatika', 'Ormawa'],
            ['HIMA D3 Sistem Informasi', 'Ormawa'],
        ];

        foreach ($organizations as [$name, $type]) {
            Organization::firstOrCreate(['name' => $name], ['type' => $type]);
        }
    }
}
