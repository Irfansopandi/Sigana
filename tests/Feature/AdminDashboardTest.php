<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders_key_sections(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Sigana',
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/dashboard');

        $response->assertOk();
        $response->assertSee('Dashboard Admin');
        $response->assertSee('Ringkasan Cepat');
        $response->assertSee('Aktivitas Terbaru');
        $response->assertSee('Aksi Cepat');
    }
}
