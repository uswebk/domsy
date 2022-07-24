<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\DnsResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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

        $this->middleware('can:owner,subdomain')->only(['update','delete']);

        $this->subdomainRepository = $subdomainRepository;
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getSubdomains()
    {
        $domains = Auth::user()->domains;
        $domains->load([
            'subdomains',
            'subdomains.dnsRecordType'
        ]);

        return response()->json(
            DnsResource::collection($domains),
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
