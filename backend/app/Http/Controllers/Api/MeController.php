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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\Illuminate\Http\Request $request)
    {
        $userId = Auth::id();

        if (!isset($userId)) {
            return response()->json(
                [],
                Response::HTTP_NOT_FOUND
            );
        }

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->save();

        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }
}
