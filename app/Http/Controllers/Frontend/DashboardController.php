<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Resources\MenuResource;
use App\Infrastructures\Models\Menu;
use Illuminate\Http\Response;

final class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('frontend.dashboard');
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getMenus()
    {
        // TODO: -> ApplicationService
        $menus = Menu::with(['menuItems' => function ($query) {
            $query->where('is_screen', '=', true);
        }])->where('is_nav', '=', true)->get();

        return response()->json([
            'menus' => MenuResource::collection($menus),
        ], Response::HTTP_OK);
    }
}
