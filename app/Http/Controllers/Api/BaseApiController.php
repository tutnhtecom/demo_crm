<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class BaseApiController extends Controller
{
    protected function success(
        mixed  $data    = null,
        string $message = 'Thành công',
        int    $code    = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function created(mixed $data = null, string $message = 'Tạo mới thành công'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    protected function error(
        string $message = 'Có lỗi xảy ra',
        mixed  $errors  = null,
        int    $code    = 400
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }

    protected function notFound(string $message = 'Không tìm thấy dữ liệu'): JsonResponse
    {
        return $this->error($message, null, 404);
    }

    protected function paginated(mixed $paginator, string $message = 'Thành công'): JsonResponse
    {
        return response()->json([
            'success'    => true,
            'message'    => $message,
            'data'       => $paginator->items(),
            'pagination' => [
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],
        ]);
    }
}
