<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $emailVerifyService;

    /**
     * @param \App\Services\Application\Auth\EmailVerifyService $emailVerifyService
     */
    public function __construct(
        \App\Services\Application\Auth\EmailVerifyService $emailVerifyService
    ) {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');

        $this->emailVerifyService = $emailVerifyService;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function verify(): \Illuminate\Contracts\View\View
    {
        $this->emailVerifyService->handle();

        return view('auth.main.register');
    }
}
