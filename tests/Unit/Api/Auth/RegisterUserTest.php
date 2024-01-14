<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    const PASSWORD = 'g-b*mj=zF{T4WhCcX+pN/(';

    public function test_register_user_successfully(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => 'John Doe',
            'password' => $this::PASSWORD,
            'password_confirmation' => $this::PASSWORD,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jon@mail.com'
        ]);
        $response->assertStatus(201);
    }

    public function test_register_user_with_invalid_email(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => 'John Doe',
            'password' => $this::PASSWORD,
            'password_confirmation' => $this::PASSWORD,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jonmail.com'
        ]);
        $response->assertStatus(422);
    }

    public function test_register_user_with_invalid_password(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => 'John Doe',
            'password' => '',
            'password_confirmation' => 'password',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jon@mail.com',
        ]);
        $response->assertStatus(422);
    }

    public function test_register_user_with_invalid_password_confirmation(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => 'John Doe',
            'password' => $this::PASSWORD,
            'password_confirmation' => '',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jon@mail.com',
        ]);
        $response->assertStatus(422);
    }

    public function test_register_user_with_invalid_name(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => '',
            'password' => $this::PASSWORD,
            'password_confirmation' => $this::PASSWORD,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'jon@mail.com',
        ]);
        $response->assertStatus(422);
    }

    public function test_register_user_with_invalid_first_name(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => 'John Doe',
            'password' => $this::PASSWORD,
            'password_confirmation' => $this::PASSWORD,
            'first_name' => '',
            'last_name' => 'Doe',
            'email' => 'jon@mail.com',
        ]);
        $response->assertStatus(422);
    }

    public function test_register_user_with_invalid_last_name(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => 'John Doe',
            'password' => $this::PASSWORD,
            'password_confirmation' => $this::PASSWORD,
            'first_name' => 'John',
            'last_name' => '',
            'email' => 'jon@mail.com',
        ]);
        $response->assertStatus(422);
    }
}
