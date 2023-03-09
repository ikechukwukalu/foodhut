<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * HTTP Response.
     *
     * @param string $status
     * @param int $status_code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function httpJsonResponse(string $status, int $status_code, ?array $data = null): JsonResponse
    {
        return Response::json([
            'status' => $status,
            'status_code' => $status_code,
            'data' => $data
        ]);
    }

    /**
     * Unknown Error Response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unknownErrorJsonResponse(): JsonResponse
    {
        return $this->httpJsonResponse($request, trans('general.fail'), 422,
                ['message' => trans('general.unknown_error')]);
    }
}
