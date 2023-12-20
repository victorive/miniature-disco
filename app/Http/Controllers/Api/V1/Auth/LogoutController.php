<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $token = $request->user()->token();

        $token->revoke();

        return ResponseHelper::successResponse('Logout successful');
    }
}
