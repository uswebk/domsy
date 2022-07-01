<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

final class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('frontend.account.index');
    }
}
