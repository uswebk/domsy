<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Application\Auth\RegisterService;

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
        $inputs = $request->only([
            'name',
            'email',
            'password',
            'email_verify_token',
        ]);

        try {
            $registerService->handle($inputs);
        } catch (Exception $e) {
            return view('auth.register')
            ->with($request->all())
            ->with('error', $e->getMessage());
        }

        return view('auth.registered');
    }
}
