<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            view()->share([
                'greeting' => session('greeting'),
                'failing' => session('failing')
            ]);

            return $next($request);
        });
    }

    private function redirectWithMessageByRouteMessageType(
        string $route,
        string $messageType,
        string $message
    ): \Illuminate\Http\RedirectResponse {
        return redirect()->route($route)->with($messageType, $message);
    }

    protected function redirectWithGreetingMessageByRoute(string $route, string $message): \Illuminate\Http\RedirectResponse
    {
        return $this->redirectWithMessageByRouteMessageType($route, 'greeting', $message);
    }

    protected function redirectWithFailingMessageByRoute(string $route, string $message): \Illuminate\Http\RedirectResponse
    {
        return $this->redirectWithMessageByRouteMessageType($route, 'failing', $message);
    }
}
