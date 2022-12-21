<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Account\StoreRequest;
use App\Http\Requests\Api\Account\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Infrastructures\Repositories\User\UserRepositoryInterface;
use App\Services\Application\Api\Account\ResendVerifyService;
use App\Services\Application\Api\Account\StoreService;
use App\Services\Application\Api\Account\WithdrawService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class AccountController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(private UserRepositoryInterface $userRepository)
    {
        parent::__construct();

        $this->middleware('can:owner,user')->except(['store', 'withdraw']);
    }

    /**
     * @param StoreRequest $request
     * @param StoreService $storeService
     * @return JsonResponse
     */
    public function store(
        StoreRequest $request,
        StoreService $storeService
    ): JsonResponse {
        try {
            $storeService->handle($request->makeInput());

            return response()->json(
                $storeService->getResponse(),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(
        UpdateRequest $request,
        User $user
    ): JsonResponse {
        try {
            $user->fill($request->makeInput());

            $resultUser = $this->userRepository->save($user);

            return response()->json(
                new UserResource($resultUser),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function delete(User $user): JsonResponse
    {
        $this->userRepository->delete($user);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param WithdrawService $withdrawService
     * @return JsonResponse
     */
    public function withdraw(WithdrawService $withdrawService): JsonResponse
    {
        try {
            $withdrawService->handle();

            return response()->json(
                $withdrawService->getResponse(),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param User $user
     * @param ResendVerifyService $resendVerifyService
     * @return JsonResponse
     */
    public function resendVerify(
        User $user,
        ResendVerifyService $resendVerifyService
    ): JsonResponse {
        try {
            $resendVerifyService->send($user);

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
