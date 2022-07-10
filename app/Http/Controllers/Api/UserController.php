<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Infrastructures\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class UserController
{
    public function getUsers()
    {
        $user = User::find(Auth::id());

        if (! $user->isCompany()) {
            abort(403);
        }

        $users = User::where('company_id', '=', $user->company_id)->get();

        return response()->json(
            UserResource::collection($users),
            Response::HTTP_OK
        );
    }
}
