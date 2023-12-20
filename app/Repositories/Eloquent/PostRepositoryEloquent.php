<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostRepositoryEloquent implements PostRepository
{
    public function all(): Collection
    {
        return Post::all();
    }

    public function insert(array $values): bool
    {
        return Post::query()->insert($values);
    }

    public function create(array $attributes): Model|Builder
    {
        return Post::query()->create($attributes);
    }

    public function update(array $attributes, $postId): Model|Builder
    {
        return tap($this->find($postId), function ($post) use ($attributes) {
            $post->update($attributes);
        });
    }

    public function find(int $postId): Model|Collection|Builder|array|null
    {
        return Post::query()->find($postId);
    }

    public function delete($postId)
    {
        return Post::query()->where('id', $postId)->delete();
    }
}
