<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Infrastructures\Models\Eloquent\MailCategory;
use App\Services\Application\SettingSaveService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    protected const INDEX_ROUTE = 'settings.index';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $mailCategories = MailCategory::get();
        $user = Auth::user();

        return view('client.settings', compact('user', 'mailCategories'));
    }

    public function save(
        Request $request,
        SettingSaveService $settingSaveService
    ) {
        try {
            $settingSaveService->handle($request);
        } catch (Exception $e) {
            throw $e;
        }
        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Setting Update!!');
    }
}
