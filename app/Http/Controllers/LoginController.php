<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    /**
     * User login.
     *
     * Make sure to retrieve <small class="badge badge-blue">access_token</small> after login for User authentication
     *
     * @bodyParam email string required The email of the user. Example: testuser@foodhut.com
     * @bodyParam password string required The password of the user is 12345678. Example: 12345678
     *
     * @response 200 {
     * "status": "success",
     * "status_code": 200,
     * "data": {
     *      "message": string
     *      "access_token": string
     *  }
     * }
     *
     * @group Unauthenticated APIs
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($data = LoginService::handleLogin($request)) {
            $status = trans('general.success');
            return $this->httpJsonResponse($status, 200, $data);
        }

        $status = trans('general.fail');
        return $this->httpJsonResponse($status, 401, ['message' => trans('auth.failed')]);
    }
}
