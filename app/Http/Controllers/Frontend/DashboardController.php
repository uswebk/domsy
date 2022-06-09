<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;



class DashboardController extends Controller
{
    public function index(
    ) {
        return view('frontend.dashboard');
    }
}
