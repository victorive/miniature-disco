<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Services\V1\Auth\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __construct(private readonly RegisterService $registerService)
    {
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = $this->registerService->register($request->validated());

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = $user->createToken('miniature-disco')->accessToken;

            return ResponseHelper::successResponse('Registration successful', Response::HTTP_CREATED, [
                'access_token' => $token,
                'user' => UserResource::make($user)
            ]);
        }

        return ResponseHelper::clientErrorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }
}
