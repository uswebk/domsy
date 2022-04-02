<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\ExpiredAuthenticationException;
use App\Http\Controllers\Controller;
use App\Services\Application\Auth\Verification\EmailVerifyService;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function showAuthVerifyByErrorMessage(string $errorMessage): \Illuminate\Contracts\View\View
    {
        return view('auth.verify')->with('error', $errorMessage);
    }

    public function verify(
        Request $request,
        EmailVerifyService $emailVerifyService
    ) {
        try {
            $emailVerifyService->handle($request->hash);
        } catch (ExpiredAuthenticationException $e) {
            $this->showAuthVerifyByErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->showAuthVerifyByErrorMessage($e->getMessage());
        }

        return view('auth.main.register');
    }
}
