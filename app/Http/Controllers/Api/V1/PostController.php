<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PostRequest;
use App\Http\Resources\V1\PostResource;
use App\Services\V1\PostService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(private readonly PostService $postService)
    {
    }

    public function getPosts(): JsonResponse
    {
        $posts = $this->postService->getPosts();

        if ($posts->isEmpty()) {
            return ResponseHelper::clientErrorResponse('No post found',
                Response::HTTP_OK);
        }

        return ResponseHelper::successResponse('Posts retrieved successfully', Response::HTTP_OK,
            PostResource::collection($posts));
    }

    public function getPostById(int $postId): JsonResponse
    {
        $post = $this->postService->getPostById($postId);

        if (!$post) {
            return ResponseHelper::clientErrorResponse('No post found',
                Response::HTTP_OK);
        }

        return ResponseHelper::successResponse('Post retrieved successfully', Response::HTTP_OK,
            PostResource::make($post));
    }

    public function createPost(PostRequest $request): JsonResponse
    {
        $userId = auth()->user()->id;

        $post = $this->postService->createPost($request->validated(), $userId);

        return ResponseHelper::successResponse('Post created successfully', Response::HTTP_CREATED,
            PostResource::make($post));
    }

    public function updatePost(PostRequest $request, int $postId): JsonResponse
    {
        $post = $this->postService->updatePost($request->validated(), $postId);

        return ResponseHelper::successResponse('Post updated successfully', Response::HTTP_OK,
            PostResource::make($post));
    }

    public function deletePost(int $postId): JsonResponse
    {
        $this->postService->deletePost($postId);

        return ResponseHelper::successResponse('Post deleted successfully');
    }
}
