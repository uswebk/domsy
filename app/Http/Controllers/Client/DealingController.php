<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Dealing\StoreRequest;

use App\Services\Application\DealingStoreService;

use Illuminate\Support\Facades\Auth;

class DealingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            $domainList = Auth::user()->domains->pluck('name', 'id')->toArray();
            $clientList = Auth::user()->clients->pluck('name', 'id')->toArray();
            $intervalCategories = ['Day', 'Week', 'Month', 'Year'];

            view()->share([
                'domainList' => $domainList,
                'clientList' => $clientList,
                'intervalCategories' => $intervalCategories,
            ]);

            return $next($request);
        });
    }

    public function index()
    {
        $domains = Auth::user()->domains;

        $domains->load([
            'domainDealings',
            'domainDealings.registrar',
            'domainDealings.client',
        ]);

        return view('client.dealing.index', compact('domains'));
    }

    public function new()
    {
        return view('client.dealing.new');
    }

    public function store(
        StoreRequest $request,
        DealingStoreService $dealingStoreService
    ) {
        $dealingStoreService->handle(
            $request->user_id,
            $request->domain_id,
            $request->client_id,
            $request->subtotal,
            $request->discount,
            $request->billing_date,
            $request->interval,
            $request->interval_category,
            $request->is_auto_update
        );
    }
}
