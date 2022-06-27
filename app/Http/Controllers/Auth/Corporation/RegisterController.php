<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Corporation;

use App\Http\Controllers\Auth\Controller;

final class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('auth.corporation.register');
    }

    public function register(
        \App\Http\Requests\Auth\Corporation\RegisterRequest $request,
        \App\Services\Application\Auth\Corporation\RegisterService $registerService
    ): \Illuminate\Contracts\View\View {
        $registerRequest = $request->makeInput();

        try {
            $registerService->handle($registerRequest);
        } catch (Exception $e) {
            return view('auth.corporation.register')
            ->with($request->all())
            ->with('error', $e->getMessage());
        }
        return view('auth.registered');
    }
}
