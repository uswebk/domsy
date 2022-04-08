<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Infrastructures\Models\Eloquent\Domain;

use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:owner,domain')->except(['index']);
    }

    public function index()
    {
        return view('client.domain.index', [
            'domains' => Auth::user()->domains
        ]);
    }

    public function edit(Domain $domain)
    {
    }
}
