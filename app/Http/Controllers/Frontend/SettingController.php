<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Infrastructures\Models\GeneralSettingCategory;
use App\Infrastructures\Models\MailCategory;

use Exception;

use Illuminate\Support\Facades\Auth;

final class SettingController extends Controller
{
    protected const INDEX_ROUTE = 'settings.index';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $user = Auth::user();
        $mailCategories = MailCategory::get();
        $generalSettingCategories = GeneralSettingCategory::get();

        return view('frontend.settings', compact(
            'user',
            'mailCategories',
            'generalSettingCategories'
        ));
    }

    /**
     * @param \App\Http\Requests\Frontend\Setting\SaveMailRequest $request
     * @param \App\Services\Application\SettingMailSaveService $settingSaveService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveMail(
        \App\Http\Requests\Frontend\Setting\SaveMailRequest $request,
        \App\Services\Application\SettingMailSaveService $settingSaveService
    ): \Illuminate\Http\RedirectResponse {
        $settingMailSaveRequest = $request->makeInput();

        try {
            $settingSaveService->handle($settingMailSaveRequest);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Setting Update!!');
    }

    /**
     * @param \App\Http\Requests\Frontend\Setting\SaveGeneralRequest $request
     * @param \App\Services\Application\SettingGeneralSaveService $settingSaveService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveGeneral(
        \App\Http\Requests\Frontend\Setting\SaveGeneralRequest $request,
        \App\Services\Application\SettingGeneralSaveService $settingSaveService
    ): \Illuminate\Http\RedirectResponse {
        $settingGeneralSaveRequest = $request->makeInput();
        try {
            $settingSaveService->handle($settingGeneralSaveRequest);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Setting Update!!');
    }
}
