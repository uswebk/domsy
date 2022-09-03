<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

final class SettingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('frontend.settings');
    }
}
