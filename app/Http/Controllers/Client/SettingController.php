<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Infrastructures\Models\Eloquent\MailCategory;

class SettingController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $mailCategories = json_encode(MailCategory::get());


        return view('client.settings', compact('mailCategories'));
    }

    public function post()
    {
        //
    }
}
