<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\AlreadyVerifiedException;

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;

final class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct(
    ) {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * @param \App\Services\Application\Auth\EmailVerifyService $emailVerifyService
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function verify(
        \App\Services\Application\Auth\EmailVerifyService $emailVerifyService
    ) {
        try {
            $emailVerifyService->handle();
        } catch (AlreadyVerifiedException $e) {
            return redirect('dashboard');
        }

        return view('auth.main.register');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(\Illuminate\Http\Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect('dashboard')
                        : view('auth.verify');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Infrastructures\Mails\Services\EmailVerificationService $emailVerificationService
     */
    public function resend(
        \Illuminate\Http\Request $request,
        \App\Infrastructures\Mails\Services\EmailVerificationService $emailVerificationService
    ) {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                        ? new JsonResponse([], 204)
                        : redirect('/dashboard');
        }

        $emailVerificationService->execute($request->user());

        return $request->wantsJson()
                    ? new JsonResponse([], 202)
                    : back()->with('resent', true);
    }
}
