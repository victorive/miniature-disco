<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepositoryEloquent implements UserRepository
{
    public function create(array $attributes): Model|Builder
    {
        return User::query()->create($attributes);
    }

    public function findByEmail(string $email): ?object
    {
        return User::query()->where('email', $email)->first();
    }

    public function findById(int $userId): ?object
    {
        return User::query()->find($userId);
    }
}
