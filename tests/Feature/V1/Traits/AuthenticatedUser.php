<?php

namespace Tests\Feature\V1\Traits;

use App\Models\User;

trait AuthenticatedUser
{
    private User $user;
    private User $admin;

    protected function setupAuthenticatedUser(): void
    {
        $this->user = User::factory()->create();

        $this->user->assignRole('User');
    }

    protected function setupAuthenticatedAdmin(): void
    {
        $this->admin = User::factory()->create();

        $this->admin->assignRole('Admin');
    }
}
