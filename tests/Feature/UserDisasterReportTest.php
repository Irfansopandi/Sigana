<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserDisasterReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_masyarakat_role_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'masyarakat',
        ]);

        $this->actingAs($user);

        $response = $this->get('/user/dashboard');

        $response->assertOk();
    }

    public function test_user_can_login_with_captcha_and_masyarakat_role(): void
    {
        $user = User::factory()->create([
            'email' => 'masyarakat@example.com',
            'password' => Hash::make('password123'),
            'role' => 'masyarakat',
        ]);

        $this->withSession([
            'captcha_answer' => 7,
            'captcha_question' => '3 + 4',
        ])->post('/login', [
            'email' => 'masyarakat@example.com',
            'password' => 'password123',
            'captcha' => 7,
        ])->assertRedirect(route('user.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_submit_disaster_report_with_photo_and_documents(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user);

        $response = $this->post('/laporan/bencana', [
            'title' => 'Banjir Bandang',
            'location' => 'Kota A',
            'category' => 'Banjir',
            'image' => UploadedFile::fake()->image('banjir.jpg'),
            'documentation_1' => UploadedFile::fake()->create('dokumentasi-1.pdf', 100, 'application/pdf'),
            'documentation_2' => UploadedFile::fake()->create('dokumentasi-2.pdf', 100, 'application/pdf'),
            'documentation_3' => UploadedFile::fake()->create('dokumentasi-3.pdf', 100, 'application/pdf'),
            'description_short' => 'Singkat',
            'description_long' => 'Deskripsi lengkap',
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertDatabaseHas('campaigns', [
            'title' => 'Banjir Bandang',
            'submitted_by' => $user->id,
            'report_status' => 'menunggu',
        ]);
    }
}
