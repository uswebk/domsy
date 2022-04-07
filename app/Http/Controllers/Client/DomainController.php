<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class DomainController extends Controller
{
    public function index(
    ) {
        return view('client.domain.index');
    }
}
