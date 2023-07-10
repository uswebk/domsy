<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Registrar\StoreRequest;
use App\Http\Requests\Api\Registrar\UpdateRequest;
use App\Http\Resources\RegistrarResource;
use App\Models\Registrar;
use App\Repositories\Registrar\RegistrarRepositoryInterface;
use App\Services\Application\Api\Registrar\FetchService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use function response;

final class RegistrarController extends Controller
{
    private RegistrarRepositoryInterface $registrarRepository;

    /**
     * @param RegistrarRepositoryInterface $registrarRepository
     */
    public function __construct(RegistrarRepositoryInterface $registrarRepository)
    {
        parent::__construct();

        $this->middleware('can:owner,registrar')->except(['fetch', 'store']);

        $this->registrarRepository = $registrarRepository;
    }

    /**
     * @param FetchService $fetchService
     * @return JsonResponse
     */
    public function fetch(FetchService $fetchService): JsonResponse
    {
        try {
            return response()->json($fetchService->getResponse(Auth::id()));
        } catch (ModelNotFoundException $e) {
            return response()->json([], Response::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $registrar = $this->registrarRepository->store($request->makeInput());

            return response()->json(
                new RegistrarResource($registrar),
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
     * @param Registrar $registrar
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Registrar $registrar): JsonResponse
    {
        try {
            $registrar->fill($request->makeInput());
            $registrar = $this->registrarRepository->save($registrar);

            return response()->json(
                new RegistrarResource($registrar),
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
     * @param Registrar $registrar
     * @return JsonResponse
     */
    public function delete(Registrar $registrar): JsonResponse
    {
        try {
            $this->registrarRepository->delete($registrar);

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
