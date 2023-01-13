<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Client\StoreRequest;
use App\Http\Requests\Api\Client\UpdateRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Services\Application\Api\Client\FetchService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ClientController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('can:owner,client')->except(['fetch', 'store']);
    }

    /**
     * @param FetchService $fetchService
     * @return JsonResponse
     */
    public function fetch(FetchService $fetchService): JsonResponse
    {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @param StoreRequest $request
     * @param ClientRepositoryInterface $clientRepository
     * @return JsonResponse
     */
    public function store(StoreRequest $request, ClientRepositoryInterface $clientRepository): JsonResponse
    {
        try {
            $client = $clientRepository->store($request->makeInput());

            return response()->json(
                new ClientResource($client),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param UpdateRequest $request
     * @param Client $client
     * @param ClientRepositoryInterface $clientRepository
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Client $client, ClientRepositoryInterface $clientRepository): JsonResponse
    {
        try {
            $client->fill($request->makeInput());
            $client = $clientRepository->save($client);

            return response()->json(
                new ClientResource($client),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param Client $client
     * @param ClientRepositoryInterface $clientRepository
     * @return JsonResponse
     */
    public function delete(Client $client, ClientRepositoryInterface $clientRepository): JsonResponse
    {
        try {
            $clientRepository->delete($client);

            return response()->json(
                [],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
