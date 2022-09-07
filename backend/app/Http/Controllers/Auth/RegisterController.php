<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\Response;

final class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('auth.register');
    }

    /**
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     * @param \App\Services\Application\Auth\RegisterService $registerService
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(
        \App\Http\Requests\Auth\RegisterRequest $request,
        \App\Services\Application\Auth\RegisterService $registerService
    ) {
        try {
            $registerService->handle($request->makeInput());

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param \App\Http\Requests\Auth\Corporation\RegisterRequest $request
     * @param \App\Services\Application\Auth\Corporation\RegisterService $registerService
     * @return\Illuminate\Http\JsonResponse
     */
    public function corporationRegister(
        \App\Http\Requests\Auth\Corporation\RegisterRequest $request,
        \App\Services\Application\Auth\Corporation\RegisterService $registerService
    ) {
        try {
            $registerService->handle($request->makeInput());

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
