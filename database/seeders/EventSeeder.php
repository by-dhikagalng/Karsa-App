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
        $events = [
            [ // Data KSM Vtech
                'organization' => 'KSM Veterantech',
                'title' => 'Tech For Society',
                'category' => 'seminar_workshop',
                'description' => 'Seminar untuk pembelajaran teknologi umum & dasar kepada masyarakat umum.',
                'location' => 'Auditorium BTI',
                'days_to_event' => 14,
                'days_to_deadline' => 10,
                'registration_url' => 'https://example.com/register/TFS',
            ],
            
            [ // Data KSM Mulmed
                'organization' => 'KSM Multimedia',
                'title' => 'Pelatihan Desain Grafis',
                'category' => 'seminar_workshop',
                'description' => 'Pelatihan dasar desain grafis untuk mahasiswa UPNVJ.',
                'location' => 'Lab Komputer FIK',
                'days_to_event' => 17,
                'days_to_deadline' => 12,
                'registration_url' => 'https://example.com/register/desain',
            ],

            [ // Data KSM CyberSec
                'organization' => 'KSM CyberSecurity',
                'title' => 'Cyber Security Awareness',
                'category' => 'seminar_workshop',
                'description' => 'Seminar mengenai keamanan digital dan kesadaran terhadap ancaman siber.',
                'location' => 'Auditorium BTI',
                'days_to_event' => 20,
                'days_to_deadline' => 15,
                'registration_url' => 'https://example.com/register/cyber',
            ],

            [ // Data KSM IOT
                'organization' => 'KSM IOT',
                'title' => 'Workshop Internet of Things',
                'category' => 'seminar_workshop',
                'description' => 'Workshop pengenalan teknologi Internet of Things untuk mahasiswa FIK UPNVJ.',
                'location' => 'Lab Komputer FIK',
                'days_to_event' => 12,
                'days_to_deadline' => 8,
                'registration_url' => 'https://example.com/register/iot',
            ],

            [ // Data BEMF-ik
                'organization' => 'BEM-Fik',
                'title' => 'Seminar Nasional Mahasiswa',
                'category' => 'seminar_workshop',
                'description' => 'Seminar nasional yang terbuka untuk mahasiswa UPNVJ.',
                'location' => 'Auditorium BTI',
                'days_to_event' => 25,
                'days_to_deadline' => 20,
                'registration_url' => 'https://example.com/register/seminar',
            ],

            [ // Data HIMA S1 Sisfor 
                'organization' => 'HIMA S1 Sistem Informasi',
                'title' => 'Open Recruitment HIMA S1 SI',
                'category' => 'beasiswa_lainnya',
                'description' => 'Pembukaan registrasi organisasi HIMA S1 Sistem Informasi untuk mahasiswa S1 Sistem Informasi FIK UPNVJ.',
                'location' => 'FIK UPNVJ',
                'days_to_event' => 10,
                'days_to_deadline' => 3,
                'registration_url' => 'https://example.com/register/OPRECHIMAS1SI',
            ],

            [ // Data Hima IF
                'organization' => 'HIMA Informatika',
                'title' => 'Coding Competition',
                'category' => 'lomba',
                'description' => 'Kompetisi pemrograman untuk mahasiswa umum seluruh universitas di-Indonesia.',
                'location' => 'FIK UPNVJ',
                'days_to_event' => 5,
                'days_to_deadline' => -2,
                'registration_url' => 'https://example.com/register/coding',
            ],

            [ // Data Hima D3 SI
                'organization' => 'HIMA D3 Sistem Informasi',
                'title' => 'Sharing Session Teknologi',
                'category' => 'seminar_workshop',
                'description' => 'Sharing session mengenai perkembangan teknologi dan pengalaman mahasiswa FIK UPNVJ.',
                'location' => 'Lab Komputer FIK',
                'days_to_event' => 18,
                'days_to_deadline' => 13,
                'registration_url' => 'https://example.com/register/sharing',
            ],

            [ // Data OpRec Hima IF
                'organization' => 'HIMA Informatika',
                'title' => 'Open Recruitment HIMA Informatika FIK UPNVJ',
                'category' => 'beasiswa_lainnya',
                'description' => 'Pembukaan registrasi organisasi HIMA S1 Informatika untuk mahasiswa S1 Informatika FIK UPNVJ.',
                'location' => 'FIK UPNVJ',
                'days_to_event' => 22,
                'days_to_deadline' => 20,
                'registration_url' => 'https://example.com/register/OPRECHIMAIF',
            ],

            [ // Data OpRec Hima D3 SI
                'organization' => 'HIMA D3 Sistem Informasi',
                'title' => 'Open Recruitment HIMA D3 Sistem Informasi FIK UPNVJ',
                'category' => 'beasiswa_lainnya',
                'description' => 'Pembukaan registrasi organisasi HIMA D3 Sistem Informasi untuk mahasiswa D3 Sistem Informasi FIK UPNVJ.',
                'location' => 'FIK UPNVJ',
                'days_to_event' => 18,
                'days_to_deadline' => 15,
                'registration_url' => 'https://example.com/register/OPRECHIMAD3SI',
            ],

            [ // Data BEMF-ik
                'organization' => 'BEM-Fik',
                'title' => 'Company Visit to Astra Indonesia',
                'category' => 'seminar_workshop',
                'description' => 'Pelaksanaan Company Visit ke Astra Indonesia dengan Seminar dan Workshop From Professionals!',
                'location' => 'Astra Indonesia',
                'days_to_event' => 14,
                'days_to_deadline' => 10,
                'registration_url' => 'https://example.com/register/COMPVISASTRA',
            ],

            [ // Data KSM Vtech
                'organization' => 'KSM Veterantech',
                'title' => 'Study Club Public',
                'category' => 'seminar_workshop',
                'description' => 'Sesi pembelajaran dengan mentor professional di bidang lingkup teknologi.',
                'location' => 'FIK UPNVJ',
                'days_to_event' => 20,
                'days_to_deadline' => 14,
                'registration_url' => 'https://example.com/register/SCP',
            ],
        ];

        foreach ($events as $data) {
            $organization = Organization::where('name', $data['organization'])->firstOrFail();

            Event::firstOrCreate(
                [
                'organization_id' => $organization->id,
                'title' => $data['title'],
                ],

                [
                'category' => $data['category'],
                'description' => $data['description'],
                'location' => $data['location'],
                'event_date' => now()->addDays($data['days_to_event'])->toDateString(),
                'registration_deadline' => now()->addDays($data['days_to_deadline'])->toDateString(),
                'registration_url' => $data['registration_url'],
                'poster_path' => null,
                ]
            );
        }
    }
}
