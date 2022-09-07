<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\RegistrarResource;
use Illuminate\Http\Response;

final class RegistrarController extends Controller
{
    private $registrarRepository;

    /**
     * @param \App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface $registrarRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface $registrarRepository
    ) {
        parent::__construct();

        $this->middleware('can:owner,registrar')->except(['fetch','store']);

        $this->registrarRepository = $registrarRepository;
    }

    /**
     * @param \App\Services\Application\Api\Registrar\FetchService $fetchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(
        \App\Services\Application\Api\Registrar\FetchService $fetchService
    ) {
        return response()->json(
            $fetchService->getResponse(),
            Response::HTTP_OK
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        \App\Http\Requests\Api\Registrar\StoreRequest $request,
    ) {
        try {
            $registrar = $this->registrarRepository->store($request->makeInput());

            return response()->json(
                new RegistrarResource($registrar),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        \App\Http\Requests\Api\Registrar\UpdateRequest $request,
        \App\Infrastructures\Models\Registrar $registrar
    ) {
        try {
            $registrar->fill($request->makeInput());
            $registrar = $this->registrarRepository->save($registrar);

            return response()->json(
                new RegistrarResource($registrar),
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
     * @param \App\Infrastructures\Models\Registrar $registrar
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(
        \App\Infrastructures\Models\Registrar $registrar
    ) {
        try {
            $this->registrarRepository->delete($registrar);

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
