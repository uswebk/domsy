<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Exception;
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
     * @param \App\Services\Application\Api\Account\StoreService $storeService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        \App\Http\Requests\Api\Account\StoreRequest $request,
        \App\Services\Application\Api\Account\StoreService $storeService
    ) {
        try {
            $storeService->handle($request->makeInput());

            return response()->json(
                $storeService->getResponse(),
                Response::HTTP_OK
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param \App\Http\Requests\Api\Account\UpdateRequest $request
     * @param \App\Infrastructures\Models\User $user
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
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
