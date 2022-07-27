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
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function get()
    {
        $user = User::find(Auth::id());

        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }
}
