<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Infrastructures\Models\Eloquent\Client;

use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    protected const INDEX_ROUTE = 'client.index';

    protected $clientRepository;

    /**
     * @param \App\Infrastructures\Repositories\Client\ClientRepositoryInterface $clientRepository
     */
    public function __construct(
        \App\Infrastructures\Repositories\Client\ClientRepositoryInterface $clientRepository
    ) {
        parent::__construct();

        $this->middleware('can:owner,client')->except(['index', 'new', 'store']);

        $this->clientRepository = $clientRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $clients = Auth::user()->clients;

        return view('frontend.client.index', compact('clients'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function new(): \Illuminate\Contracts\View\View
    {
        return view('frontend.client.new');
    }

    /**
     * @param \App\Infrastructures\Models\Eloquent\Client $client
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(
        \App\Infrastructures\Models\Eloquent\Client $client
    ): \Illuminate\Contracts\View\View {
        return view('frontend.client.edit', compact('client'));
    }

    /**
     * @param \App\Http\Requests\Frontend\Client\UpdateRequest $request
     * @param \App\Infrastructures\Models\Eloquent\Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        \App\Http\Requests\Frontend\Client\UpdateRequest $request,
        \App\Infrastructures\Models\Eloquent\Client $client
    ): \Illuminate\Http\RedirectResponse {
        $attributes = $request->makeInput();

        $client->fill($attributes);

        $this->clientRepository->save($client);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Client Update!!');
    }

    /**
     * @param \App\Http\Requests\Frontend\Client\StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        \App\Http\Requests\Frontend\Client\StoreRequest $request
    ): \Illuminate\Http\RedirectResponse {
        $attributes = $request->makeInput();

        $this->clientRepository->store($attributes);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Client Create!!');
    }

    /**
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Client $client): \Illuminate\Http\RedirectResponse
    {
        $this->clientRepository->delete($client);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Client Delete!!');
    }
}
