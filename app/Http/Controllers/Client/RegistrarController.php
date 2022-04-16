<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class RegistrarController extends Controller
{
    public function index()
    {
        $registrars = Auth::user()->registrars;

        return view('client.registrar.index', compact('registrars'));
    }

    public function new()
    {
        return view('client.registrar.new');
    }
}
