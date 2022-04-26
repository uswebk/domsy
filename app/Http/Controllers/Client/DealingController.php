<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            $domainList = Auth::user()->domains->pluck('name', 'id')->toArray();
            $clientList = Auth::user()->clients->pluck('name', 'id')->toArray();

            view()->share([
                'domainList' => $domainList,
                'clientList' => $clientList,
            ]);

            return $next($request);
        });
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
        return view('client.dealing.new');
    }

    public function store(
        Request $request
    ) {

        // Application Service
        // ドメイン整合性Check
        // クライアント整合性Check
        // データ保存(Repository)

        dd($request);
    }
}
