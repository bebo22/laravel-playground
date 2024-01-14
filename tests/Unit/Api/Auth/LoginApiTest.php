<?php

namespace Tests\Unit\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginApiTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    const LOGIN_URL = '/api/v1/login';
    const EMAIL = 'mail@mail.com';
    const PASSWORD = 'g-b*mj=zF{T4WhCcX+pN/(';
    
    public function test_login_validation(): void
    {
        $response = $this->post($this::LOGIN_URL, [
            'email' => $this::EMAIL,
            'password' => ''
        ]);
        $response->assertStatus(422);
    }
    public function test_login_success(): void
    {
        User::factory()->create([
            'name' => $this->faker->name,
            'email' => $this::EMAIL,
            'password' => $this::PASSWORD,
            'email_verified_at' => '2021-01-01 00:00:00',
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);

        $response = $this->post($this::LOGIN_URL, [
            'email' => $this::EMAIL,
            'password' => $this::PASSWORD,
        ]);
        $response->assertStatus(200);
    }
    public function test_login_email_not_verified(): void
    {
        User::factory()->create([
            'name' => $this->faker->name,
            'email' => $this::EMAIL,
            'password' => $this::PASSWORD,
            'email_verified_at' => null,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);

        $response = $this->post($this::LOGIN_URL, [
            'email' => $this::EMAIL,
            'password' => $this::PASSWORD,
        ]);
        $response->assertStatus(403);
    }
    public function test_login_wrong_credentials(): void
    {
        User::factory()->create([
            'name' => $this->faker->name,
            'email' => $this::EMAIL,
            'password' => $this::PASSWORD,
            'email_verified_at' => '2021-01-01 00:00:00',
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ]);

        $response = $this->post($this::LOGIN_URL, [
            'email' => $this::EMAIL,
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(401);
    }
}
