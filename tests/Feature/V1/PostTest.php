<?php

namespace Tests\Feature\V1;

use App\Models\Post;
use Tests\Feature\V1\Traits\AuthenticatedUser;
use Tests\TestCase;

class PostTest extends TestCase
{
    use AuthenticatedUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAuthenticatedUser();
        $this->setupAuthenticatedAdmin();
    }

    private string $url = 'api/v1/posts';

    public function testUserCanCreateAPost(): void
    {
        $post = Post::factory()->raw();

        $this->actingAs($this->user)->postJson($this->url, $post)->assertCreated()
            ->assertJsonFragment([
                'status' => true,
                'message' => 'Post created successfully',
            ]);
    }

    public function testAdminCanGetPosts(): void
    {
        Post::factory()->count(3)->for($this->user)->create();

        $this->actingAs($this->admin)->getJson($this->url)->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'message' => 'Posts retrieved successfully',
            ]);
    }

    public function testAdminCanReadAPost(): void
    {
        $post = Post::factory()->for($this->user)->create();

        $this->actingAs($this->admin)->getJson($this->url . '/' . $post->id)->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'message' => 'Post retrieved successfully',
            ])->assertJsonPath('data.id', $post->id);
    }

    public function testAdminCanUpdateAPost(): void
    {
        $post = Post::factory()->for($this->user)->create();

        $updatedPost = Post::factory()->for($this->user)->raw();

        $this->actingAs($this->admin)->putJson($this->url . '/' . $post->id, $updatedPost)
            ->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'message' => 'Post updated successfully',
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => $updatedPost['title']
        ]);
    }

    public function testAdminCanDeleteAPost(): void
    {
        $post = Post::factory()->for($this->user)->create();

        $this->actingAs($this->admin)->deleteJson($this->url . '/' . $post->id)
            ->assertOk()
            ->assertJsonFragment([
                'status' => true,
                'message' => 'Post deleted successfully',
            ]);

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title
        ]);
    }
}
