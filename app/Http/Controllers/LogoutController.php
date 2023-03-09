<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    /**
     * User logout.
     *
     * This API logs a user out of a single session
     *
     * @header Authorization Bearer {Your key}
     *
     * @response 200
     *
     * {
     * "status": "success",
     * "status_code": 200,
     * "data": {
     *      "message": string
     *  }
     * }
     *
     * @authenticated
     * @group Authenticated APIs
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        $data = [
            'access_token' => null,
            'message' => trans('auth.logout')
        ];

        return $this->httpJsonResponse(trans('general.success'), 200, $data);
    }

    /**
     * User logout from all sessions.
     *
     * This API logs a user out of every session and clears all user tokens
     *
     * @header Authorization Bearer {Your key}
     *
     * @response 200
     *
     * {
     * "status": "success",
     * "status_code": 200,
     * "data": {
     *      "message": string
     *  }
     * }
     *
     * @authenticated
     * @group Authenticated APIs
     */
    public function logoutFromAllSessions(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        $data = [
            'access_token' => null,
            'message' => trans('auth.logout')
        ];

        return $this->httpJsonResponse(trans('general.success'), 200, $data);
    }
}
