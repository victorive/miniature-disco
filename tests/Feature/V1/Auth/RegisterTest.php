<?php

namespace Tests\Feature\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    private string $url = 'api/v1/auth/register';

    protected function setUp(): void
    {
        parent::setUp();

        $this->registrationData = User::factory()->raw();
    }

    private array $registrationData;

    public function testUserCanRegister(): void
    {
        $response = $this->postJson($this->url, $this->registrationData);

        $response->assertCreated()
            ->assertJsonFragment([
                'status' => true,
                'access_token' => $response->json('data.access_token'),
            ]);

        $user = User::query()->where('email', $this->registrationData['email'])->first();

        $this->assertTrue($user->hasRole('User'));
    }

    public function testUserCannotRegisterWithInvalidCredentials(): void
    {
        $invalidCredentials = array_fill_keys(array_keys($this->registrationData), '');

        $response = $this->postJson($this->url, $invalidCredentials);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name', 'email', 'password'
            ]);
    }
}
