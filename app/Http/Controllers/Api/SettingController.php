<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserMailSettingResource;

use App\Infrastructures\Models\MailCategory;
use Illuminate\Http\Response;

final class SettingController
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

    public function getGenerals()
    {
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
}
