<?php


namespace App\Traits;

use App\Helpers\ResponseCode;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

trait Response
{

    protected function successWithoutData(string $message): JsonResponse
    {
        return response()->json([
            "success" => true,
            "code" => ResponseCode::SUCCESS,
            "message" => $message,
            "server_time" => date('Y-m-d H:i:s')
        ]);
    }

    protected function successWithData(string $message, $data): JsonResponse
    {

        $utf8Data = json_decode(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE), true);

        return response()->json([
            "success" => true,
            "code" => ResponseCode::SUCCESS,
            "data" => $utf8Data,
            "message" => $message,
            "server_time" => date('Y-m-d H:i:s')
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    protected function successWithDataPagination(string $message, $data, $items, $extra = []): JsonResponse
    {
        return response()->json([
            "success" => true,
            "code" => ResponseCode::SUCCESS,
            "data" => array_merge([
                'data' => $data, // Resource collection for ads
                'total' => $items->total(),
                'count' => $items->count(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'total_pages' => $items->lastPage(),
            ], $extra),
            "message" => $message,
            "server_time" => date('Y-m-d H:i:s')
        ]);
    }

    protected function errorResponse(string $message, $code = ResponseCode::GENERAL_ERROR): JsonResponse
    {
        return response()->json([
            "success" => false,
            "code" => $code,
            "message" => $message,
            "server_time" => date('Y-m-d H:i:s')
        ], 422);
    }


    protected function notFoundResponse(string $message, $code = ResponseCode::NOT_FOUND): JsonResponse
    {
        return response()->json([
            "success" => false,
            "code" => $code,
            "message" => $message,
            "server_time" => date('Y-m-d H:i:s')
        ], 404);
    }

    protected function unauthenticatedResponse(): JsonResponse
    {
        return response()->json([
            "success" => false,
            "code" => ResponseCode::UN_AUTHENTICATED,
            "message" => "Unauthenticated",
            "server_time" => date('Y-m-d H:i:s')
        ], 403);
    }

    protected function unauthorizedResponse($message): JsonResponse
    {
        return response()->json([
            "success" => false,
            "code" => ResponseCode::UN_AUTHORIZED,
            "message" => $message,
            "server_time" => date('Y-m-d H:i:s')
        ], 401);
    }

    protected function notAllowedResponse($message): JsonResponse
    {
        return response()->json([
            "success" => false,
            "code" => ResponseCode::NOT_ALLOWED,
            "message" => $message,
            "server_time" => date('Y-m-d H:i:s')
        ], 405);
    }

    protected function paginationResponse(LengthAwarePaginator $pagination, array $data): JsonResponse
    {
        return response()->json([
            "success" => true,
            "code" => ResponseCode::SUCCESS,
            "message" => "Success",
            "data" => [
                'total_items' => $pagination->total(),
                'current_page' => $pagination->currentPage(),
                'last_page' => $pagination->lastPage(),
                'per_page' => $pagination->perPage(),
                'orders' => $data,
            ],
            "server_time" => date('Y-m-d H:i:s')
        ], 200);
    }

    protected function generalError(): JsonResponse
    {
        return response()->json([
            "success" => false,
            "code" => ResponseCode::GENERAL_ERROR,
            "message" => "General Error",
            "server_time" => date('Y-m-d H:i:s')
        ], 422);
    }
}
