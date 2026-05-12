<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $response = $this->get("/login");
        $response->assertStatus(200);
    }

    public function test_user_can_login_with_username(): void
    {
        $user = User::factory()->create([
            "username" => "testuser",
            "password" => bcrypt("password123"),
            "email_verified_at" => now(),
        ]);

        $response = $this->post("/login", [
            "username" => "testuser",
            "password" => "password123",
        ]);

        $response->assertRedirect("/home");
        $this->assertAuthenticated();
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create([
            "username" => "testuser",
            "password" => bcrypt("password123"),
            "email_verified_at" => now(),
        ]);

        $response = $this->post("/login", [
            "username" => "testuser",
            "password" => "wrongpassword",
        ]);

        $response->assertSessionHasErrors("username");
        $this->assertGuest();
    }
}
