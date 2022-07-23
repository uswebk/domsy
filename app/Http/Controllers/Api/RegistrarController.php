<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\RegistrarResource;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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

        $this->registrarRepository = $registrarRepository;
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getRegistrars()
    {
        $registrars = Auth::user()->registrars;

        return response()->json(
            RegistrarResource::collection($registrars),
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

        $this->registrarRepository->store($attribute);

        return response()->json(
            [],
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
        $this->registrarRepository->save($registrar);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
