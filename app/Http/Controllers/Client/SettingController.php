<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Infrastructures\Models\Eloquent\MailCategory;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $user = Auth::user();
        $mailCategories = MailCategory::get();

        return view('client.settings', compact('user', 'mailCategories'));
    }

    public function post()
    {
        //
    }
}
