<?php

namespace App\Repositories\Contracts;

interface UserRepository
{
    public function create(array $attributes);

    public function findByEmail(string $email);
}
