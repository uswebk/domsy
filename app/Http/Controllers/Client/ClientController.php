<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Client\StoreRequest;
use App\Http\Requests\Client\Client\UpdateRequest;
use App\Infrastructures\Models\Eloquent\Client;
use App\Infrastructures\Repositories\Client\ClientRepositoryInterface;

use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    protected const INDEX_ROUTE = 'client.index';

    protected $clientRepository;

    /**
     * @param ClientRepositoryInterface $clientRepository
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        parent::__construct();

        $this->middleware('can:owner,client')->except(['index', 'new', 'store']);

        $this->clientRepository = $clientRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $clients = Auth::user()->clients;

        return view('client.client.index', compact('clients'));
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function new(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('client.client.new');
    }

    /**
     * @param Client $client
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Client $client): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('client.client.edit', compact('client'));
    }

    /**
     * @param UpdateRequest $request
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateRequest $request,
        Client $client
    ): \Illuminate\Http\RedirectResponse {
        $attributes = $request->only([
            'name',
            'name_kana',
            'email',
            'zip',
            'address',
            'phone_number',
        ]);

        $client->fill($attributes);

        $this->clientRepository->save($client);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Client Update!!');
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $attributes = $request->only([
            'name',
            'user_id',
            'name_kana',
            'email',
            'zip',
            'address',
            'phone_number',
        ]);

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
