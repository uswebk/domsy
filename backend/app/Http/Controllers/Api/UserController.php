<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\Application\Api\User\FetchService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Response;

final class UserController
{
    /**
     * @param FetchService $fetchService
     * @return JsonResponse
     */
    public function fetch(FetchService $fetchService): JsonResponse
    {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }
}
