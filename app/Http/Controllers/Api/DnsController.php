<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

final class DnsController extends Controller
{
    protected $subdomainRepository;

    /**
     * @param \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Subdomain\SubdomainRepositoryInterface $subdomainRepository
    ) {
        parent::__construct();

        $this->middleware('can:owner,subdomain')->except(['fetch', 'store']);

        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @param \App\Services\Application\DnsFetchService $dnsFetchService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Services\Application\DnsFetchService $dnsFetchService
    ) {
        return response()->json(
            $dnsFetchService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\DNS\UpdateRequest $request
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\DNS\UpdateRequest $request,
        \App\Infrastructures\Models\Subdomain $subdomain,
    ) {
        $attributes = $request->makeInput();

        $subdomain->fill($attributes);

        $this->subdomainRepository->save($subdomain);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\DNS\StoreRequest $request
     * @param \App\Services\Application\DnsStoreService $dnsStoreService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\DNS\StoreRequest $request,
        \App\Services\Application\DnsStoreService $dnsStoreService
    ) {
        $subdomainRequest = $request->makeInput();
        $dnsStoreService->handle($subdomainRequest);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete(
        \App\Infrastructures\Models\Subdomain $subdomain
    ) {
        $this->subdomainRepository->delete($subdomain);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
