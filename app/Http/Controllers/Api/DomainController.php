<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\DomainResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class DomainController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,domain')->except(['getDomains', 'store']);
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getDomains()
    {
        $domains = Auth::user()->domains;

        return response()->json(
            DomainResource::collection($domains),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Domain\UpdateRequest $request
     * @param \App\Infrastructures\Models\Domain $domain
     * @param \App\Services\Application\DomainUpdateService $domainUpdateService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\Domain\UpdateRequest $request,
        \App\Infrastructures\Models\Domain $domain,
        \App\Services\Application\DomainUpdateService $domainUpdateService
    ) {
        $domainRequest = $request->makeInput();
        $domainUpdateService->handle($domainRequest, $domain);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Domain\StoreRequest $request
     * @param \App\Services\Application\DomainStoreService $domainStoreService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\Domain\StoreRequest $request,
        \App\Services\Application\DomainStoreService $domainStoreService
    ) {
        $domainRequest = $request->makeInput();

        $domainStoreService->handle($domainRequest);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\Domain $domain
     * @param \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete(
        \App\Infrastructures\Models\Domain $domain,
        \App\Infrastructures\Repositories\Domain\DomainRepositoryInterface $domainRepository
    ) {
        $domainRepository->delete($domain);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
