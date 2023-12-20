<?php

namespace App\Services\V1\Auth;

use App\Repositories\Contracts\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function findByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }
}
