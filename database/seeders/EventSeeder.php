<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Organization;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $veterantech = Organization::where('name', 'KSM Veterantech')->first();
        $multimedia = Organization::where('name', 'KSM Multimedia')->first();
        $cybersecurity = Organization::where('name', 'KSM CyberSecurity')->first();
        $iot = Organization::where('name', 'KSM IOT')->first();
        $bem = Organization::where('name', 'BEM-Fik')->first();
        $himaSi = Organization::where('name', 'HIMA S1 Sistem Informasi')->first();
        $himaIf = Organization::where('name', 'HIMA Informatika')->first();
        $himaD3 = Organization::where('name', 'HIMA D3 Sistem Informasi')->first();

        Event::create([
            'organization_id' => $veterantech->id,
            'title' => 'Tech For Society',
            'category' => 'Seminar',
            'description' => 'Seminar untuk pembelajaran teknologi umum & dasar kepada masyarakat umum.',
            'location' => 'Auditorium BTI',
            'event_date' => '2026-12-05',
            'registration_url' => 'https://example.com/register/TFS',
            'poster_path' => null,
        ]);

        Event::create([
            'organization_id' => $multimedia->id,
            'title' => 'Pelatihan Desain Grafis',
            'category' => 'Pelatihan',
            'description' => 'Pelatihan dasar desain grafis untuk mahasiswa UPNVJ.',
            'location' => 'Lab Komputer FIK',
            'event_date' => '2026-12-07',
            'registration_url' => 'https://example.com/register/desain',
            'poster_path' => null,
        ]);

        Event::create([
            'organization_id' => $cybersecurity->id,
            'title' => 'Cyber Security Awareness',
            'category' => 'Seminar',
            'description' => 'Seminar mengenai keamanan digital dan kesadaran terhadap ancaman siber.',
            'location' => 'Auditorium BTI',
            'event_date' => '2026-12-10',
            'registration_url' => 'https://example.com/register/cyber',
            'poster_path' => null,
        ]);

        Event::create([
            'organization_id' => $iot->id,
            'title' => 'Workshop Internet of Things',
            'category' => 'Workshop',
            'description' => 'Workshop pengenalan teknologi Internet of Things untuk mahasiswa FIK UPNVJ.',
            'location' => 'Lab Komputer FIK',
            'event_date' => '2026-12-12',
            'registration_url' => 'https://example.com/register/iot',
            'poster_path' => null,
        ]);

        Event::create([
            'organization_id' => $bem->id,
            'title' => 'Seminar Nasional Mahasiswa',
            'category' => 'Seminar',
            'description' => 'Seminar nasional yang terbuka untuk mahasiswa UPNVJ.',
            'location' => 'Auditorium BTI',
            'event_date' => '2026-12-15',
            'registration_url' => 'https://example.com/register/seminar',
            'poster_path' => null,
        ]);

        Event::create([
            'organization_id' => $himaSi->id,
            'title' => 'Open Recruitment HIMA S1 SI',
            'category' => 'Organisasi',
            'description' => 'Pembukaan registrasi organisasi HIMA S1 Sistem Informasi untuk Mahasiswa S1 Sistem Informasi FIK UPNVJ.',
            'location' => 'FIK UPNVJ',
            'event_date' => '2026-12-18',
            'registration_url' => 'https://example.com/register/OPRECHIMAS1SI',
            'poster_path' => null,
        ]);

        Event::create([
            'organization_id' => $himaIf->id,
            'title' => 'Coding Competition',
            'category' => 'Lomba',
            'description' => 'Kompetisi pemrograman untuk mahasiswa umum seluruh Universitas di-Indonesia.',
            'location' => 'FIK UPNVJ',
            'event_date' => '2026-12-20',
            'registration_url' => 'https://example.com/register/coding',
            'poster_path' => null,
        ]);

        Event::create([
            'organization_id' => $himaD3->id,
            'title' => 'Sharing Session Teknologi',
            'category' => 'Sharing Session',
            'description' => 'Sharing session mengenai perkembangan teknologi dan pengalaman mahasiswa FIK UPNVJ.',
            'location' => 'Lab Komputer FIK',
            'event_date' => '2026-12-22',
            'registration_url' => 'https://example.com/register/sharing',
            'poster_path' => null,
        ]);
    }
}
