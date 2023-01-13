<?php

namespace App\Http\Controllers\Auth;

use App\Services\Application\Auth\SocialService;
use Exception;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response;

final class SocialController extends Controller
{
    /**
     * @param $provider
     * @return string
     */
    public function redirect($provider): string
    {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }

    /**
     * @param $provider
     * @param SocialService $socialService
     * @return JsonResponse
     */
    public function callback($provider, SocialService $socialService): JsonResponse
    {
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
