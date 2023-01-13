<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\Corporation\RegisterRequest as CorporationRegisterRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Application\Auth\Corporation\RegisterService as CorporationRegisterService;
use App\Services\Application\Auth\RegisterService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
     * @param RegisterRequest $request
     * @param RegisterService $registerService
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, RegisterService $registerService): JsonResponse
    {
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
     * @param CorporationRegisterRequest $request
     * @param CorporationRegisterService $registerService
     * @return JsonResponse
     */
    public function corporationRegister(CorporationRegisterRequest $request, CorporationRegisterService $registerService): JsonResponse
    {
        try {
            $registerService->handle($request->makeInput());

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            report($e);
            return response()->json(
                ['message' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
