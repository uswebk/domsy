<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Auth;

class DealingController extends Controller
{
    public function index(
    ) {
        $domains = Auth::user()->domains;

        $domains->load([
            'domainDealings',
        ]);

        dd($domains);

        return view('client.dealing.index');
    }
}
