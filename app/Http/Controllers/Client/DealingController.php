<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Dealing\StoreRequest;
use App\Infrastructures\Models\Eloquent\DomainDealing;
use App\Services\Application\DealingStoreService;

use Illuminate\Support\Facades\Auth;

class DealingController extends Controller
{
    protected const INDEX_ROUTE = 'dealing.index';

    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,domainDealing')->only(['edit']);

        $this->middleware(function ($request, $next) {
            $domainList = Auth::user()->domains->pluck('name', 'id')->toArray();
            $clientList = Auth::user()->clients->pluck('name', 'id')->toArray();
            $intervalCategories = DomainDealing::getIntervalCategories();

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
            'domainDealings.client',
        ]);

        return view('client.dealing.index', compact('domains'));
    }

    public function new()
    {
        return view('client.dealing.new');
    }

    public function edit(DomainDealing $domainDealing)
    {
        return view('client.dealing.edit', compact('domainDealing'));
    }

    public function store(
        StoreRequest $request,
        DealingStoreService $dealingStoreService
    ) {
        try {
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
        } catch (\Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Create');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Create Success!!');
    }
}
