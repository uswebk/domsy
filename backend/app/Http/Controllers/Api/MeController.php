<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class MeController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch()
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
     * @param \App\Http\Requests\Api\Me\UpdateRequest $request
     * @param \App\Repositories\User\UserRepositoryInterface $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        \App\Http\Requests\Api\Me\UpdateRequest $request,
        \App\Repositories\User\UserRepositoryInterface $userRepository
    ) {
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
