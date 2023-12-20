<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Services\V1\Auth\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = $this->userService->findByEmail($request->input('email'));

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = $user->createToken('miniature-disco')->accessToken;

            return ResponseHelper::successResponse('Login successful', Response::HTTP_OK, [
                'access_token' => $token
            ]);
        }

        return ResponseHelper::clientErrorResponse('Invalid credentials', Response::HTTP_UNAUTHORIZED);
    }
}
