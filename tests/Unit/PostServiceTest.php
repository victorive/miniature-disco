<?php

namespace Tests\Unit;

use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\UserRepository;
use App\Services\V1\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    /**
     * @throws RequestException
     */
    public function testCheckUserExists(): void
    {
        Config::set('services.free-api.url', 'https://example.com');

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('findById')->once()->with(1)->andReturn(null);

        $postRepository = Mockery::mock(PostRepository::class);
        $postService = new PostService($userRepository, $postRepository);

        $this->expectException(ModelNotFoundException::class);
        $postService->processAndStoreData(1);
    }

    /**
     * @throws RequestException
     */
    public function testFetchAndPrepareData(): void
    {
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('findById')->zeroOrMoreTimes()->with(1)->andReturn(true);

        $postRepository = Mockery::mock(PostRepository::class);

        $postService = Mockery::mock(PostService::class, [$userRepository, $postRepository])->makePartial();
        $postService->shouldReceive('getExternalPosts')->once()->andReturn([
            ['userId' => 1, 'title' => 'Post 1', 'body' => 'Body 1'],
            ['userId' => 2, 'title' => 'Post 2', 'body' => 'Body 2']
        ]);

        $data = $postService->fetchAndPrepareData(1);

        $this->assertCount(1, $data);
        $this->assertEquals('Post 1', $data[0]['title']);
        $this->assertEquals('Body 1', $data[0]['body']);
    }
}
