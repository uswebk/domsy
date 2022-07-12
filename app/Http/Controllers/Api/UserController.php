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

    public function update(
        \App\Http\Requests\Api\User\UpdateRequest $request,
        User $user
    ) {
        $data = $request->all();

        $user->fill($data)->save();

        return response()->json(
            [
            'message' => 'Success!',
            ],
            Response::HTTP_OK
        );
    }
}
