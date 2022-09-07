<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\SubdomainResource;
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
     * @param \App\Services\Application\Api\Dns\FetchService $fetchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(
        \App\Services\Application\Api\Dns\FetchService $fetchService
    ) {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\DNS\UpdateRequest $request
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        \App\Http\Requests\Api\DNS\UpdateRequest $request,
        \App\Infrastructures\Models\Subdomain $subdomain,
    ) {
        try {
            $subdomain->fill($request->makeInput());
            $subdomain = $this->subdomainRepository->save($subdomain);

            return response()->json(
                new SubdomainResource($subdomain),
                Response::HTTP_OK
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param \App\Http\Requests\Api\DNS\StoreRequest $request
     * @param \App\Services\Application\DnsStoreService $dnsStoreService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        \App\Http\Requests\Api\DNS\StoreRequest $request,
        \App\Services\Application\Api\Dns\StoreService $storeService
    ) {
        try {
            $storeService->handle($request->makeInput());

            return response()->json(
                $storeService->getResponse(),
                Response::HTTP_OK
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param \App\Infrastructures\Models\Subdomain $subdomain
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(
        \App\Infrastructures\Models\Subdomain $subdomain
    ) {
        try {
            $this->subdomainRepository->delete($subdomain);

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch(Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
