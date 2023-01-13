<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Me\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
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
            return response()->json(
                [],
                Response::HTTP_NOT_FOUND
            );
        }

        try {
            $user = User::findOrFail($userId);

            return response()->json(
                new UserResource($user),
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param UpdateRequest $request
     * @param UserRepositoryInterface $userRepository
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, UserRepositoryInterface $userRepository): JsonResponse
    {
        $userId = Auth::id();

        if (!isset($userId)) {
            return response()->json(
                [],
                Response::HTTP_NOT_FOUND
            );
        }

        $user = User::find($userId);
        $user->fill($request->makeInput());
        $userRepository->save($user);

        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }
}
