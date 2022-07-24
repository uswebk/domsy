<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\ClientResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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

        $this->middleware('can:owner,client')->except(['getClients','store']);

        $this->clientRepository = $clientRepository;
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getClients()
    {
        $clients = Auth::user()->clients;

        return response()->json(
            ClientResource::collection($clients),
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
