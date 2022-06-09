<?php

namespace App\Http\Controllers\Frontend;

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

    /**
     * @param string $route
     * @param string $messageType
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectWithMessageByRouteMessageType(
        string $route,
        string $messageType,
        string $message
    ): \Illuminate\Http\RedirectResponse {
        return redirect()->route($route)->with($messageType, $message);
    }

    /**
     * @param string $route
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectWithGreetingMessageByRoute(string $route, string $message): \Illuminate\Http\RedirectResponse
    {
        return $this->redirectWithMessageByRouteMessageType($route, 'greeting', $message);
    }

    /**
     * @param string $route
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectWithFailingMessageByRoute(string $route, string $message): \Illuminate\Http\RedirectResponse
    {
        return $this->redirectWithMessageByRouteMessageType($route, 'failing', $message);
    }
}
