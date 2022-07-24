<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\DealingResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class DealingController extends Controller
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getDealings()
    {

        // TODO: ApplicationService化
        $domains = new Collection();

        $_domains = Auth::user()->domains;

        $_domains->load([
            'domainDealings',
            'domainDealings.client',
        ]);

        foreach ($_domains as $domain) {
            if ($domain->domainDealings->isEmpty()) {
                continue;
            }

            $domains->push($domain);
        }


        return response()->json(
            DealingResource::collection($domains),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Dealing\UpdateRequest $request
     * @param \App\Infrastructures\Models\DomainDealing $domainDealing
     * @param \App\Services\Application\DealingUpdateService $dealingUpdateService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\Dealing\UpdateRequest $request,
        \App\Infrastructures\Models\DomainDealing $domainDealing,
        \App\Services\Application\DealingUpdateService $dealingUpdateService
    ) {
        $domainDealingRequest = $request->makeInput();
        $dealingUpdateService->handle($domainDealingRequest, $domainDealing);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Dealing\StoreRequest $request
     * @param \App\Services\Application\DealingStoreService $dealingStoreService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\Dealing\StoreRequest $request,
        \App\Services\Application\DealingStoreService $dealingStoreService
    ) {
        $domainDealingRequest = $request->makeInput();
        $dealingStoreService->handle($domainDealingRequest);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
