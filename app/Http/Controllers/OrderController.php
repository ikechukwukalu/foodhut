<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    /**
     * Product Order.
     *
     * @header Authorization Bearer {Your key}
     *
     * @bodyParam products object[] A product being ordered. Example: [{"product_id": 1, "quantity": 2}]
     * @bodyParam products.product_id integer required A product being ordered. Example: 1
     * @bodyParam products.quantity integer required The quantity being ordered. Example: 2
     *
     * @response 200 {
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
    public function order(OrderRequest $request): JsonResponse
    {
        if ($data = OrderService::handleOrder($request)) {
            $status = trans('general.success');
            return $this->httpJsonResponse($status, 200, $data);
        }

        return $this->unknownErrorJsonResponse();
    }
}
