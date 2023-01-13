<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Setting\SaveGeneralRequest;
use App\Http\Requests\Api\Setting\SaveMailRequest;
use App\Http\Resources\GeneralSettingResource;
use App\Http\Resources\UserMailSettingResource;
use App\Models\GeneralSettingCategory;
use App\Models\MailCategory;
use App\Services\Application\Api\Setting\GeneralSaveService;
use App\Services\Application\Api\Setting\MailSaveService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SettingController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getMails(): JsonResponse
    {
        $mailCategories = MailCategory::get();

        return response()->json(
            UserMailSettingResource::collection($mailCategories),
            Response::HTTP_OK
        );
    }

    /**
     * @return JsonResponse
     */
    public function getGenerals(): JsonResponse
    {
        $generalSettingCategories = GeneralSettingCategory::get();

        return response()->json(
            GeneralSettingResource::collection($generalSettingCategories),
            Response::HTTP_OK
        );
    }

    /**
     * @param SaveMailRequest $request
     * @param MailSaveService $mailSaveService
     * @return JsonResponse
     */
    public function saveMails(SaveMailRequest $request, MailSaveService $mailSaveService): JsonResponse
    {
        try {
            $mailSaveService->handle($request->makeInput());

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

    /**
     * @param SaveGeneralRequest $request
     * @param GeneralSaveService $generalSaveService
     * @return JsonResponse
     */
    public function saveGenerals(SaveGeneralRequest $request, GeneralSaveService $generalSaveService): JsonResponse
    {
        try {
            $generalSaveService->handle($request->makeInput());

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
