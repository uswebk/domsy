<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Application\Auth\RegisterService;

use Exception;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.register');
    }

    public function register(
        RegisterRequest $request,
        RegisterService $registerService
    ) {
        try {
            $registerService->handle(
                $request->name,
                $request->email,
                $request->password,
                $request->email_verify_token,
            );
        } catch (Exception $e) {
            return view('auth.register')
            ->with($request->all())
            ->with('error', $e->getMessage());
        }

        return view('auth.registered');
    }
}
