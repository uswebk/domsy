<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Infrastructures\Models\Menu;

final class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        // TODO: -> QueryService
        $menus = Menu::with(['menuItems'])
        ->where('is_nav', '=', true)->get();

        return view('frontend.dashboard', compact('menus'));
    }
}
