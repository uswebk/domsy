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
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
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
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
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
     * @param \App\Services\Application\SettingMailSaveService $settingSaveService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function saveMails(
        \App\Http\Requests\Api\Setting\SaveMailRequest $request,
        \App\Services\Application\SettingMailSaveService $settingSaveService
    ) {
        $settingMailSaveRequest = $request->makeInput();
        $settingSaveService->handle($settingMailSaveRequest);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Setting\SaveGeneralRequest $request
     * @param \App\Services\Application\SettingGeneralSaveService $settingSaveService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function saveGenerals(
        \App\Http\Requests\Api\Setting\SaveGeneralRequest $request,
        \App\Services\Application\SettingGeneralSaveService $settingSaveService
    ) {
        $settingGeneralSaveRequest = $request->makeInput();
        $settingSaveService->handle($settingGeneralSaveRequest);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
