<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

final class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('frontend.dashboard');
    }
}
