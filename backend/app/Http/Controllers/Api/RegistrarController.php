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
     * @param \App\Services\Application\RegistrarFetchService $registrarFetchService
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function fetch(
        \App\Services\Application\RegistrarFetchService $registrarFetchService
    ) {
        return response()->json(
            $registrarFetchService->getResponseData(),
            Response::HTTP_OK
        );
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(
        \App\Http\Requests\Api\Registrar\StoreRequest $request,
    ) {
        $attribute = $request->makeInput();

        $registrar = $this->registrarRepository->store($attribute);

        return response()->json(
            new RegistrarResource($registrar),
            Response::HTTP_OK
        );
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(
        \App\Http\Requests\Api\Registrar\UpdateRequest $request,
        \App\Infrastructures\Models\Registrar $registrar
    ) {
        $attributes = $request->makeInput();

        $registrar->fill($attributes);
        $registrar = $this->registrarRepository->save($registrar);

        return response()->json(
            new RegistrarResource($registrar),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Infrastructures\Models\Registrar $registrar
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function delete(
        \App\Infrastructures\Models\Registrar $registrar
    ) {
        $this->registrarRepository->delete($registrar);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
