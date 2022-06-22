<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

final class CorporationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('auth.corporation.register');
    }

    public function register(
        \Illuminate\Http\Request $request
    ): \Illuminate\Contracts\View\View {
        return view('auth.registered');
    }
}
