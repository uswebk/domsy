<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Resources\MenuResource;
use App\Infrastructures\Models\Menu;

final class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // TODO: -> ApplicationService
        $menus = Menu::with(['menuItems' => function ($query) {
            $query->where('is_screen', '=', true);
        }])->where('is_nav', '=', true)->get();

        return view('frontend.dashboard', [
            'menus' => json_encode(MenuResource::collection($menus)),
        ]);
    }
}
