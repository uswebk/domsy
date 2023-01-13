<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected string $redirectTo = RouteServiceProvider::DASHBOARD;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function credentials(Request $request): array
    {
        return array_merge($request->only($this->username(), 'password'), ['deleted_at' => null]);
    }

    /**
     * @param Request $request
     * @param $user
     * @return void
     */
    protected function authenticated(Request $request, $user): void
    {
        $user->last_login_at = now();
        $user->save();
    }
}
