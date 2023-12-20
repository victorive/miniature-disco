<?php

namespace App\Repositories\Contracts;

interface PostRepository
{
    public function all();

    public function create(array $attributes);

    public function find(int $postId);

    public function update(array $attributes, $postId);

    public function delete($postId);

    public function insert(array $values);
}
