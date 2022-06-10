<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Infrastructures\Models\Eloquent\Menu;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $menus = Menu::where('is_screen', '=', true)->get();

        return view('frontend.dashboard', compact('menus'));
    }
}
