<?php

namespace App\Services\V1\Auth;

use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function register(array $formData)
    {
        $formData = $this->prepareFormData($formData);

        return DB::transaction(function () use ($formData) {

            $user = $this->userRepository->create($formData);

            $user->assignRole('User');
            $user->load('roles.permissions');

            return $user;
        });
    }


    private function prepareFormData(array $formData): array
    {
        return collect($formData)->merge(['password' => Hash::make($formData['password'])])->toArray();
    }
}
