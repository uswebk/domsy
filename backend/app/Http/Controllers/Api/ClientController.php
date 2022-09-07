<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\ClientResource;
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
     * @param \App\Services\Application\Api\Client\FetchService $fetchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(
        \App\Services\Application\Api\Client\FetchService $fetchService
    ) {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Client\StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        \App\Http\Requests\Api\Client\StoreRequest $request
    ) {
        try {
            $client = $this->clientRepository->store($request->makeInput());

            return response()->json(
                new ClientResource($client),
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
     * @param \App\Http\Requests\Api\Client\UpdateRequest $request
     * @param \App\Infrastructures\Models\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        \App\Http\Requests\Api\Client\UpdateRequest $request,
        \App\Infrastructures\Models\Client $client
    ) {
        try {
            $client->fill($request->makeInput());
            $client = $this->clientRepository->save($client);

            return response()->json(
                new ClientResource($client),
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
     * @param \App\Infrastructures\Models\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(
        \App\Infrastructures\Models\Client $client
    ) {
        try {
            $this->clientRepository->delete($client);

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
