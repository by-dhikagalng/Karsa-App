<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login Admin Karsa App');
    }

    public function test_guest_redirected_to_login_when_accessing_admin(): void
    {
        $response = $this->get('/admin/events');

        $response->assertRedirect(route('login'));
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $org = Organization::create(['name' => 'KSM A', 'type'=> 'KSM']);
        User::create([
            'name' => 'Admin A',
            'email' => 'admina@karsa.test',
            'password' => 'password',
            'role' => 'admin_ormawa',
            'organization_id' => $org->id,
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'admina@karsa.test',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_ormawa_can_login_manage_own_event_and_blocked_from_other_org_event(): void
    {
        $orgA = Organization::create(['name' => 'KSM A', 'type'=> 'KSM']);
        $orgB = Organization::create(['name' => 'KSM B', 'type'=> 'KSM']);

        $adminA = User::create([
            'name' => 'Admin A',
            'email' => 'admina@karsa.test',
            'password' => 'password',
            'role' => 'admin_ormawa',
            'organization_id' => $orgA->id,
        ]);

        $eventA = Event::create([
            'organization_id' => $orgA->id,
            'title' => 'Event A',
            'category' => 'lomba',
            'description' => 'Desc A',
            'location' => 'FIK',
            'event_date' => now()->addDays(10)->toDateString(),
            'registration_deadline' => now()->addDays(5)->toDateString(),
            'registration_url' => 'https://example.com/a',
        ]);

        $eventB = Event::create([
            'organization_id' => $orgB->id,
            'title' => 'Event B',
            'category' => 'lomba',
            'description' => 'Desc B',
            'location' => 'FIK',
            'event_date' => now()->addDays(10)->toDateString(),
            'registration_deadline' => now()->addDays(5)->toDateString(),
            'registration_url' => 'https://example.com/b',
        ]);

        // Login berhasil
        $this->post('/login', [
            'email' => 'admina@karsa.test',
            'password' => 'password',
        ])->assertRedirect(route('admin.events.index'));

        $this->assertAuthenticatedAs($adminA);

        // Boleh akses event milik organisasi sendiri
        $this->get("admin/events/{$eventA->id}/edit")->assertStatus(200);

        // Ditolak (403) saat coba akses/ubah/hapus event milik organisasi lain
        $this->get("admin/events/{$eventB->id}/edit")->assertStatus(403);
        $this->put("admin/events/{$eventB->id}")->assertStatus(403);
        $this->delete("admin/events/{$eventB->id}")->assertStatus(403);
        
        // Logout berhasil $ session terhapus
        $this->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();
    }
    
    public function test_super_admin_can_access_all_organization_events(): void
    {
        $orgA = Organization::create(['name' => 'KSM A', 'type' => 'KSM']);
        $orgB = Organization::create(['name' => 'KSM B', 'type' => 'KSM']);

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@karsa.test',
            'password' => 'password_superAdmin',
            'role' => 'super_admin',
            'organization_id' => null,
        ]);

        $eventB = Event::create([
            'organization_id' => $orgB->id,
            'title' => 'Event B',
            'category' => 'lomba',
            'description' => 'Desc B',
            'location' => 'FIK',
            'event_date' => now()->addDays(10)->toDateString(),
            'registration_deadline' => now()->addDays(5)->toDateString(),
            'registration_url' => 'https://example.com/b',
        ]);

        $this->actingAs($superAdmin)
            ->get("/admin/events/{$eventB->id}/edit")
            ->assertStatus(200);
    }
}
