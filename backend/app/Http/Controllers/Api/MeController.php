<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Me\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class MeController
{
    /**
     * @return JsonResponse
     */
    public function fetch(): JsonResponse
    {
        $userId = Auth::id();

        if (!isset($userId)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        try {
            $user = User::findOrFail($userId);
            return response()->json(new UserResource($user));
        } catch (ModelNotFoundException $e) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        $userId = Auth::id();

        if (!isset($userId)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        try {
            $user = User::findOrFail($userId)->update($request->formatData());
            return response()->json(new UserResource($user), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            report($e);
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
