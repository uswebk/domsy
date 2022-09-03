<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

final class UserController
{
    /**
     * @param \App\Services\Application\UserFetchService $userFetchService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Services\Application\UserFetchService $userFetchService
    ) {
        return response()->json(
            $userFetchService->getResponseData(),
            Response::HTTP_OK
        );
    }
}
