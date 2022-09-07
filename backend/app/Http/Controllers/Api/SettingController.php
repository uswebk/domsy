<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\GeneralSettingResource;

use App\Http\Resources\UserMailSettingResource;
use App\Infrastructures\Models\GeneralSettingCategory;
use App\Infrastructures\Models\MailCategory;

use Illuminate\Http\Response;

final class SettingController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMails()
    {
        $mailCategories = MailCategory::get();

        return response()->json(
            UserMailSettingResource::collection($mailCategories),
            Response::HTTP_OK
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGenerals()
    {
        $generalSettingCategories = GeneralSettingCategory::get();

        return response()->json(
            GeneralSettingResource::collection($generalSettingCategories),
            Response::HTTP_OK
        );
    }

    /**
      * @param \App\Http\Requests\Api\Setting\SaveMailRequest $request
      * @param \App\Services\Application\Api\Setting\MailSaveService $mailSaveService
      * @return \Illuminate\Http\JsonResponse
      */
    public function saveMails(
        \App\Http\Requests\Api\Setting\SaveMailRequest $request,
        \App\Services\Application\Api\Setting\MailSaveService $mailSaveService
    ) {
        try {
            $mailSaveService->handle($request->makeInput());

            return response()->json(
                [],
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
     * @param \App\Http\Requests\Api\Setting\SaveGeneralRequest $request
     * @param \App\Services\Application\Api\Setting\GeneralSaveService $settingSaveService
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveGenerals(
        \App\Http\Requests\Api\Setting\SaveGeneralRequest $request,
        \App\Services\Application\Api\Setting\GeneralSaveService $generalSaveService
    ) {
        try {
            $generalSaveService->handle($request->makeInput());

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
