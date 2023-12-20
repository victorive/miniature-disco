<?php

namespace App\Services\V1;

use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostService
{
    private string $url;

    public function __construct(private readonly UserRepository $userRepository,
                                private readonly PostRepository $postRepository)
    {
        $this->url = config('services.free-api.url');
    }

    /**
     * @throws RequestException
     */
    public function processAndStoreData($userId): void
    {
        $this->checkUserExists($userId);
        $data = $this->fetchAndPrepareData($userId);
        $this->storeData($userId, $data);
    }

    private function checkUserExists($userId): void
    {
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new ModelNotFoundException('User does not exist.');
        }
    }

    /**
     * @throws RequestException
     */
    public function fetchAndPrepareData($userId): array
    {
        $posts = $this->getExternalPosts();
        return $this->prepareData($userId, $posts);
    }

    /**
     * @throws RequestException
     */
    public function getExternalPosts(): array
    {
        $response = Http::accept('application/json')
            ->get($this->url . '/posts');

        $response->throwIf(!$response->successful());

        return $response->json();
    }

    protected function prepareData(int $userId, array $data): array
    {
        $userPosts = array_filter($data, function ($post) use ($userId) {
            return $post['userId'] === $userId;
        });

        $userPosts = array_slice($userPosts, 0, 5);

        return array_map(function ($post) {
            return [
                'title' => $post['title'],
                'body' => $post['body'],
                'user_id' => $post['userId']
            ];
        }, $userPosts);
    }

    public function storeData(int $userId, array $data): void
    {
        $posts = [];

        foreach ($data as $postData) {
            $posts[] = [
                'title' => $postData['title'],
                'body' => $postData['body'],
                'user_id' => $userId,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        $this->postRepository->insert($posts);
    }

    public function getPosts()
    {
        return $this->postRepository->all();
    }

    public function getPostById(int $postId)
    {
        return $this->postRepository->find($postId);
    }

    public function createPost(array $formData, int $userId)
    {
        $formData = collect($formData)->merge(['user_id' => $userId])->toArray();

        return $this->postRepository->create($formData);
    }

    public function updatePost(array $formData, int $postId)
    {
        $post = $this->postRepository->find($postId);

        if (!$post) {
            throw new NotFoundHttpException;
        }

        return $this->postRepository->update($formData, $postId);
    }

    public function deletePost(int $postId): void
    {
        $post = $this->postRepository->find($postId);

        if (!$post) {
            throw new NotFoundHttpException;
        }

        $this->postRepository->delete($postId);
    }
}
