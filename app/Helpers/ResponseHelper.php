<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    public static function informationResponse(string $message, int $code = Response::HTTP_CONTINUE, bool $status = false): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'data' => [],
            'message' => $message
        ], $code);
    }

    public static function successResponse(string $message, int $code = Response::HTTP_OK, mixed $data = [], bool $status = true): JsonResponse
    {
        $data = (object)$data;

        return response()->json([
            'status' => $status,
            'code' => $code,
            'data' => $data,
            'message' => $message
        ], $code);
    }

    public static function redirectResponse(string $message, int $code = Response::HTTP_MULTIPLE_CHOICES, bool $status = true): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'data' => [],
            'message' => $message
        ], $code);
    }

    public static function clientErrorResponse(string $message, int $code = Response::HTTP_BAD_REQUEST, bool $status = false): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'data' => [],
            'message' => $message
        ], $code);
    }

    public static function serverErrorResponse(int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'status' => false,
            'code' => $code,
            'data' => [],
            'message' => 'An error occurred. Please try again later.',
        ], $code);
    }
}
