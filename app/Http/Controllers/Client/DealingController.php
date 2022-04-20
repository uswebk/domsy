<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class DealingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    private function makeSelectItemByCollection(
        \Illuminate\Database\Eloquent\Collection $collection
    ): array {
        $selectItem = $collection->pluck('name', 'id')->toArray();

        if (isset($selectItem)) {
            return $selectItem;
        }

        return [];
    }

    public function index()
    {
        $domains = Auth::user()->domains;

        $domains->load([
            'domainDealings',
            'domainDealings.registrar',
            'domainDealings.client',
        ]);

        return view('client.dealing.index', compact('domains'));
    }

    public function new()
    {
        $domainList = $this->makeSelectItemByCollection(Auth::user()->domains);
        $registrarList = $this->makeSelectItemByCollection(Auth::user()->registrars);
        $clientList = $this->makeSelectItemByCollection(Auth::user()->clients);

        return view('client.dealing.new', compact('domainList', 'registrarList', 'clientList'));
    }
}
