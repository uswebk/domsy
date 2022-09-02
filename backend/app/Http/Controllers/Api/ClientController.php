<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

final class ClientController extends Controller
{
    protected $clientRepository;

    /**
     * @param \App\Infrastructures\Repositories\Client\ClientRepositoryInterface $clientRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Client\ClientRepositoryInterface $clientRepository
    ) {
        parent::__construct();

        $this->middleware('can:owner,client')->except(['fetch','store']);

        $this->clientRepository = $clientRepository;
    }

    /**
     * @param \App\Services\Application\ClientFetchService $clientFetchService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Services\Application\ClientFetchService $clientFetchService
    ) {
        return response()->json(
            $clientFetchService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Client\StoreRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\Client\StoreRequest $request
    ) {
        $attributes = $request->makeInput();

        $this->clientRepository->store($attributes);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * Undocumented function
     *
     * @param \App\Http\Requests\Api\Client\UpdateRequest $request
     * @param \App\Infrastructures\Models\Client $client
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\Client\UpdateRequest $request,
        \App\Infrastructures\Models\Client $client
    ) {
        $attributes = $request->makeInput();

        $client->fill($attributes);

        $this->clientRepository->save($client);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\Client $client
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete(
        \App\Infrastructures\Models\Client $client
    ) {
        $this->clientRepository->delete($client);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
