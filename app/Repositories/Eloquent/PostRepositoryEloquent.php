<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PostRepositoryEloquent implements PostRepository
{
    public function insert(array $values): bool
    {
        return Post::query()->insert($values);
    }
}
