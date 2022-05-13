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

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        parent::__construct();

        $this->middleware('can:owner,client')->except(['index', 'new', 'store']);

        $this->clientRepository = $clientRepository;
    }

    public function index()
    {
        $clients = Auth::user()->clients;

        return view('client.client.index', compact('clients'));
    }

    public function new()
    {
        return view('client.client.new');
    }

    public function edit(Client $client)
    {
        return view('client.client.edit', compact('client'));
    }

    public function update(
        UpdateRequest $request,
        Client $client
    ) {
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

    public function store(StoreRequest $request)
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

    public function delete(Client $client)
    {
        $this->clientRepository->delete($client);

        return $this->redirectWithGreetingMessageByRoute(self::INDEX_ROUTE, 'Client Delete!!');
    }
}
