<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Registrar\StoreRequest;
use App\Http\Requests\Frontend\Registrar\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Registrar;
use App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class RegistrarController extends Controller
{
    protected const INDEX_ROUTE = 'registrar.index';

    protected $registrarRepository;

    public function __construct(RegistrarRepositoryInterface $registrarRepository)
    {
        parent::__construct();

        $this->middleware('can:owner,registrar')->except(['index', 'new', 'store']);

        $this->registrarRepository = $registrarRepository;
    }

    public function index()
    {
        $registrars = Auth::user()->registrars;

        return view('client.registrar.index', compact('registrars'));
    }

    public function new()
    {
        return view('client.registrar.new');
    }

    public function edit(Registrar $registrar)
    {
        return view('client.registrar.edit', compact('registrar'));
    }

    public function update(
        UpdateRequest $request,
        Registrar $registrar
    ) {
        $attributes = $request->only([
            'name',
            'link',
            'note',
        ]);

        try {
            $registrar->fill($attributes);

            $this->registrarRepository->save($registrar);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Registrar Update!!');
    }

    public function store(StoreRequest $request)
    {

        // Todo: make DTO
        $attributes = $request->only([
            'name',
            'user_id',
            'link',
            'note',
        ]);

        try {
            $this->registrarRepository->store($attributes);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Create');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Registrar Create!!');
    }

    public function delete(Registrar $registrar)
    {
        $this->registrarRepository->delete($registrar);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Registrar Delete!!');
    }
}
