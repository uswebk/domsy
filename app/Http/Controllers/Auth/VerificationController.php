<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Application\Auth\EmailVerifyService;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $emailVerifyService;

    public function __construct(
        EmailVerifyService $emailVerifyService
    ) {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');

        $this->emailVerifyService = $emailVerifyService;
    }

    public function verify()
    {
        $this->emailVerifyService->handle();

        return view('auth.main.register');
    }
}
