<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Registrar\StoreRequest;
use App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface;

use Illuminate\Support\Facades\Auth;

class RegistrarController extends Controller
{
    protected const INDEX_ROUTE = 'registrar.index';

    public function __construct()
    {
        parent::__construct();
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

    public function store(
        StoreRequest $request,
        RegistrarRepositoryInterface $registrarRepository
    ) {
        $attributes = $request->only([
            'name',
            'user_id',
            'link',
            'note',
        ]);

        try {
            $registrarRepository->store($attributes);
        } catch (Exception $e) {
            throw $e;
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Registrar Create!!');
    }
}
