<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Infrastructures\Models\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class UserController
{
    public function getUsers(
        \App\Services\Application\Api\User\GetUsersService $getUsersService
    ) {

        // TODO: ApplicationServiceに移行
        $user = User::find(Auth::id());

        if (! $user->isCompany()) {
            abort(403);
        }

        // TODO: 自分 && 削除ユーザー除く
        $users = User::where('company_id', '=', $user->company_id)->get();

        return response()->json(
            UserResource::collection($users),
            Response::HTTP_OK
        );
    }

    public function update(
        \App\Http\Requests\Api\User\UpdateRequest $request,
        \App\Infrastructures\Models\User $user
    ) {

        // TODO: ApplicationServiceに移行
        $data = $request->all();

        $user->fill($data)->save();

        return response()->json(
            ['message' => 'Success!'],
            Response::HTTP_OK
        );
    }

    public function delete(
        \App\Infrastructures\Models\User $user
    ) {
        $user->fill([
            'deleted_at' => now(),
        ])->save();
    }
}
