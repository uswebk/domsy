<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

final class DashboardController extends Controller
{
    /**
     * @param \App\Services\Application\DashboardIndexService $applicationService
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(
        \App\Services\Application\DashboardIndexService $applicationService
    ) {
        return view('frontend.dashboard', [
            'applicationService' => $applicationService,
        ]);
    }
}
