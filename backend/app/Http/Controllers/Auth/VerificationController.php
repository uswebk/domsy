<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\AlreadyVerifiedException;
use App\Mails\Services\EmailVerificationService;
use App\Services\Application\Auth\EmailVerifyService;
use Exception;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('signed')->only(['url']);
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * @param EmailVerifyService $emailVerifyService
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function url(EmailVerifyService $emailVerifyService)
    {
        $id = Auth::id();
        if (!isset($id)) {
            return redirect(config('app.frontend_url') . '/login');
        }

        try {
            $emailVerifyService->handle();
            return redirect(config('app.frontend_url') . '/verify/complete');
        } catch (AlreadyVerifiedException $e) {
            return redirect(config('app.frontend_url') . '/mypage');
        } catch (Exception $e) {
            return redirect(config('app.frontend_url') . '/login');
        }
    }

    /**
     * Show the email verification notice.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect('mypage')
            : view('auth.verify');
    }

    /**
     * @param Request $request
     * @param EmailVerificationService $emailVerificationService
     */
    public function resend(Request $request, EmailVerificationService $emailVerificationService)
    {
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
