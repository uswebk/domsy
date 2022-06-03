<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Infrastructures\Models\Interval;

use Exception;

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
            $intervalCategories = Interval::getIntervalList();

            view()->share([
                'domainList' => $domainList,
                'clientList' => $clientList,
                'intervalCategories' => $intervalCategories,
            ]);

            return $next($request);
        });
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $domains = Auth::user()->domains;

        $domains->load([
            'domainDealings',
            'domainDealings.client',
        ]);

        return view('client.dealing.index', compact('domains'));
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function new(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('client.dealing.new');
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory {
        return view('client.dealing.edit', compact('domainDealing'));
    }

    /**
     * @param \App\Http\Requests\Client\Dealing\UpdateRequest $request
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @param \App\Services\Application\DealingUpdateService $dealingUpdateService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        \App\Http\Requests\Client\Dealing\UpdateRequest $request,
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing,
        \App\Services\Application\DealingUpdateService $dealingUpdateService
    ): \Illuminate\Http\RedirectResponse {
        $domainDealingRequest = $request->makeDto();

        try {
            $dealingUpdateService->handle($domainDealingRequest, $domainDealing);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Update Success!!');
    }

    /**
     * @param \App\Http\Requests\Client\Dealing\StoreRequest $request
     * @param \App\Services\Application\DealingStoreService $dealingStoreService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        \App\Http\Requests\Client\Dealing\StoreRequest $request,
        \App\Services\Application\DealingStoreService $dealingStoreService
    ): \Illuminate\Http\RedirectResponse {
        $domainDealingRequest = $request->makeDto();

        try {
            $dealingStoreService->handle($domainDealingRequest);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Create');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Create Success!!');
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function detail(
        \App\Infrastructures\Models\Eloquent\DomainDealing $domainDealing
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory {
        $this->authorize('owner', $domainDealing);

        $domainDealing->load(['domain','client']);

        return view('client.dealing.detail', compact('domainDealing'));
    }
}
