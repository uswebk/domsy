<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\ExpiredAuthenticationException;
use App\Http\Controllers\Controller;
use App\Services\Application\Auth\EmailVerifyService;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;

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
        Request $request,
        EmailVerifyService $emailVerifyService,
    ) {
        try {
            $emailVerifyService->handle($request);
            return view('auth.main.register');
        } catch (ExpiredAuthenticationException $e) {
            $view = $this->showAuthVerifyByErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $view = $this->showAuthVerifyByErrorMessage($e->getMessage());
        }

        return $view;
    }
}
