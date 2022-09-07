<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

final class UserController
{
    /**
     * @param \App\Services\Application\UserFetchService $userFetchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(
        \App\Services\Application\Api\User\FetchService $fetchService
    ) {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }
}
