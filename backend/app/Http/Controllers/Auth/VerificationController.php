<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\AlreadyVerifiedException;
use Exception;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct(
    ) {
        $this->middleware('signed')->only(['url']);
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * @param \App\Services\Application\Auth\EmailVerifyService $emailVerifyService
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function url(
        \App\Services\Application\Auth\EmailVerifyService $emailVerifyService
    ) {
        $id = Auth::id();
        if (!isset($id)) {
            return redirect(config('app.frontend_url') . '/login');
        }

        try {
            $emailVerifyService->handle();
            return redirect(config('app.frontend_url') . '/verify/complete');
        } catch (AlreadyVerifiedException $e) {
            return redirect(config('app.frontend_url') . '/mypage');
        } catch(Exception $e) {
            return redirect(config('app.frontend_url') . '/login');
        }
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
                        ? redirect('mypage')
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
                        : redirect('/mypage');
        }

        $emailVerificationService->execute($request->user());

        return $request->wantsJson()
                    ? new JsonResponse([], 202)
                    : back()->with('resent', true);
    }
}
