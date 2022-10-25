<?php

namespace App\Http\Controllers\Auth;

use App\Services\Application\Auth\SocialService;
use Exception;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

final class SocialController extends Controller
{
    public function redirect($provider): string
    {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }

    public function callback(
        $provider,
        SocialService $socialService
    ): \Illuminate\Http\JsonResponse {
        try {
            $socialService->handle($provider);

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
