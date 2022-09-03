<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function credentials(\Illuminate\Http\Request $request): array
    {
        return array_merge($request->only($this->username(), 'password'), ['deleted_at' => null]);
    }
}
