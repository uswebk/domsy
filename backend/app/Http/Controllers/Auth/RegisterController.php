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
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function register(
        \App\Http\Requests\Auth\RegisterRequest $request,
        \App\Services\Application\Auth\RegisterService $registerService
    ) {
        $registerRequest = $request->makeInput();

        try {
            $registerService->handle($registerRequest);
        } catch (Exception $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Auth\Corporation\RegisterRequest $request
     * @param \App\Services\Application\Auth\Corporation\RegisterService $registerService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function corporationRegister(
        \App\Http\Requests\Auth\Corporation\RegisterRequest $request,
        \App\Services\Application\Auth\Corporation\RegisterService $registerService
    ) {
        $registerRequest = $request->makeInput();

        $registerService->handle($registerRequest);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
