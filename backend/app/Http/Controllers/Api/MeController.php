<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Infrastructures\Models\User;
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

        $user = User::find(Auth::id());
        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Me\UpdateRequest $request
     * @param \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        \App\Http\Requests\Api\Me\UpdateRequest $request,
        \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository
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
