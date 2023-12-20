<?php

namespace Tests\Feature\V1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Feature\V1\Traits\AuthenticatedUser;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use AuthenticatedUser;

    private string $url = 'api/v1/auth/login';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAuthenticatedUser();
        $this->setupAuthenticatedAdmin();
    }

    public function testUserCanLoginWithValidCredentials(): void
    {
        $response = $this->postJson($this->url, [
                'email' => $this->user->email,
                'password' => 'Password1234#'
            ]);

        $response->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'access_token' => $response->json('data.access_token'),
            ]);
    }

    public function testAdminCanLoginWithValidCredentials(): void
    {
        $response = $this->postJson($this->url, [
            'email' => $this->admin->email,
            'password' => 'Password1234#'
        ]);

        $response->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'access_token' => $response->json('data.access_token'),
            ]);
    }

    public function testUserCannotLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson($this->url, [
                'email' => $this->user->email,
                'password' => ''
            ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('password');
    }
}
