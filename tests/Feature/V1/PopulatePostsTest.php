<?php

namespace Tests\Feature\V1;

use App\Services\V1\PostService;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

class PopulatePostsTest extends TestCase
{
    public function testPostsCanBePopulatedForUser(): void
    {
        $postService = Mockery::mock(PostService::class);
        $postService->shouldReceive('processAndStoreData')->once()->with(1);

        $this->app->instance(PostService::class, $postService);

        $exitCode = Artisan::call('populate:posts', [
            '--userid' => 1,
        ]);

        $this->assertEquals(0, $exitCode);
    }
}
