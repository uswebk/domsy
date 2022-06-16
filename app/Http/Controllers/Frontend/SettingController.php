<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Infrastructures\Models\Eloquent\GeneralSettingCategory;
use App\Infrastructures\Models\Eloquent\MailCategory;

use Exception;

use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
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
     * @param \App\Http\Requests\Frontend\Setting\SaveRequest $request
     * @param \App\Services\Application\SettingSaveService $settingSaveService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveMail(
        \App\Http\Requests\Frontend\Setting\SaveRequest $request,
        \App\Services\Application\SettingSaveService $settingSaveService
    ): \Illuminate\Http\RedirectResponse {
        $settingSaveRequest = $request->makeInput();

        try {
            $settingSaveService->handle($settingSaveRequest);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }
        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Setting Update!!');
    }

    // TODO: Validation
    public function saveGeneral(
        \Illuminate\Http\Request $request
    ) {
        // TODO: Save Class
        dd($request->all());
    }
}
