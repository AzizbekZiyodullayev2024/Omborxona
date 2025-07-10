<?php

use Illuminate\Http\JsonResponse;

function success_paginate($paginator, string $message = 'Success', int $statusCode = 200): JsonResponse
{
    return response()->json([
        'status' => true,
        'message' => $message,
        'data' => $paginator->items(),
        'pagination' => [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
        ],
    ], $statusCode);
}

function success_response($data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
{
    return response()->json([
        'status' => true,
        'message' => $message,
        'data' => $data,
    ], $statusCode);
}
