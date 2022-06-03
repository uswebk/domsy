<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Setting\SaveRequest;

use App\Infrastructures\Models\Eloquent\MailCategory;
use App\Services\Application\SettingSaveService;
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
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $mailCategories = MailCategory::get();
        $user = Auth::user();

        return view('client.settings', compact('user', 'mailCategories'));
    }

    /**
     * @param SaveRequest $request
     * @param SettingSaveService $settingSaveService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(
        SaveRequest $request,
        SettingSaveService $settingSaveService
    ): \Illuminate\Http\RedirectResponse {
        $settingSaveDto = $request->makeDto();

        try {
            $settingSaveService->handle($settingSaveDto);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }
        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Setting Update!!');
    }
}
