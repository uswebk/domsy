<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\RegistrarResource;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class RegistrarController extends Controller
{
    public function getRegistrars()
    {
        $registrars = Auth::user()->registrars;

        return response()->json(
            RegistrarResource::collection($registrars),
            Response::HTTP_OK
        );
    }

    /**
     * @param \App\Http\Requests\Api\Registrar\StoreRequest $request
     * @param \App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface $registrarRepository
     * @return void
     */
    public function store(
        \App\Http\Requests\Api\Registrar\StoreRequest $request,
        \App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface $registrarRepository
    ) {
        $attribute = $request->makeInput();

        $registrarRepository->store($attribute);

        return response()->json(
            [],
            Response::HTTP_OK
        );
    }
}
