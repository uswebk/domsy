<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\ExpiredAuthenticationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyRequest;
use App\Services\Application\Auth\EmailVerifyService;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function showAuthVerifyByErrorMessage(string $errorMessage):\Illuminate\Contracts\View\View
    {
        return view('auth.verify')->with('error', $errorMessage);
    }

    public function verify(
        VerifyRequest $request,
        EmailVerifyService $emailVerifyService
    ) {
        try {
            $emailVerifyService->handle($request->hash);
            return view('auth.main.register');
        } catch (ExpiredAuthenticationException $e) {
            $view = $this->showAuthVerifyByErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $view = $this->showAuthVerifyByErrorMessage($e->getMessage());
        }

        return $view;
    }
}
