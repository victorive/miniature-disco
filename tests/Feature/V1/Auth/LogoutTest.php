<?php

namespace Tests\Feature\V1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Feature\V1\Traits\AuthenticatedUser;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use AuthenticatedUser;

    private string $url = 'api/v1/auth/logout';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAuthenticatedUser();
    }

    public function testUserCanLogout(): void
    {
        $token = $this->user->createToken('miniature-disco')->accessToken;

        $this->withToken($token)
            ->postJson($this->url)
            ->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'data' => [],
                'message' => 'Logout successful',
            ]);
    }
}
