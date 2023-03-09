<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;

class OrderService
{

    /**
     * Handle the request.
     *
     * @param  \App\Http\Requests\OrderRequest  $request
     * @return ?array
     */
    public static function handleOrder(OrderRequest $request): ?array
    {
        $validated = $request->validated();

        return $validated;
    }
}
