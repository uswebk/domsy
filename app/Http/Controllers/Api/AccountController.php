<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

final class AccountController extends Controller
{
    private $userRepository;

    /**
     * @param \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\User\UserRepositoryInterface $userRepository
    ) {
        parent::__construct();

        $this->middleware('can:owner,user')->except(['store']);

        $this->userRepository = $userRepository;
    }

    /**
     * @param \App\Http\Requests\Api\Account\StoreRequest $request
     * @param \App\Services\Application\AccountStoreService $accountStoreService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\Account\StoreRequest $request,
        \App\Services\Application\AccountStoreService $accountStoreService
    ) {
        $accountRequest = $request->makeInput();
        $accountStoreService->handle($accountRequest);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Account\UpdateRequest $request
     * @param \App\Infrastructures\Models\User $user
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\Account\UpdateRequest $request,
        \App\Infrastructures\Models\User $user
    ) {
        $data = $request->makeInput();

        $user->fill($data);

        $this->userRepository->save($user);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\User $user
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete(
        \App\Infrastructures\Models\User $user
    ) {
        $this->userRepository->delete($user);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
