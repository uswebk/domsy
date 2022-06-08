<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegistrarController extends Controller
{
    protected const INDEX_ROUTE = 'registrar.index';

    protected $registrarRepository;

    /**
     * @param \App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface $registrarRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Registrar\RegistrarRepositoryInterface $registrarRepository
    ) {
        parent::__construct();

        $this->middleware('can:owner,registrar')->except(['index', 'new', 'store']);

        $this->registrarRepository = $registrarRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $registrars = Auth::user()->registrars;

        return view('frontend.registrar.index', compact('registrars'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function new(): \Illuminate\Contracts\View\View
    {
        return view('frontend.registrar.new');
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\Registrar $registrar
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(
        \App\Infrastructures\Models\Eloquent\Registrar $registrar
    ): \Illuminate\Contracts\View\View {
        return view('frontend.registrar.edit', compact('registrar'));
    }

    /**
     * @param \App\Http\Requests\Frontend\Registrar\UpdateRequest $request
     * @param \App\Infrastructures\Models\Eloquent\Registrar $registrar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        \App\Http\Requests\Frontend\Registrar\UpdateRequest $request,
        \App\Infrastructures\Models\Eloquent\Registrar $registrar
    ): \Illuminate\Http\RedirectResponse {
        // TODO: make DTO
        $attributes = $request->only([
            'name',
            'link',
            'note',
        ]);

        $registrar->fill($attributes);

        try {
            $this->registrarRepository->save($registrar);
        } catch (Exception $e) {
            return $this->redirectWithFailingMessageByRoute(self::INDEX_ROUTE, 'Failing Update');
        }

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Registrar Update!!');
    }

    /**
     * @param \App\Http\Requests\Frontend\Registrar\StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        \App\Http\Requests\Frontend\Registrar\StoreRequest $request
    ): \Illuminate\Http\RedirectResponse {
        // TODO: make DTO
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

    /**
     * @param \App\Infrastructures\Models\Eloquent\Registrar $registrar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(
        \App\Infrastructures\Models\Eloquent\Registrar $registrar
    ): \Illuminate\Http\RedirectResponse {
        $this->registrarRepository->delete($registrar);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Registrar Delete!!');
    }
}
