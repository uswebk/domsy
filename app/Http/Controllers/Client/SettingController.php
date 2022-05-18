<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('client.settings');
    }

    public function post()
    {
        //
    }
}
