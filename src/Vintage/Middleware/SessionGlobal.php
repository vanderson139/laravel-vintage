<?php

namespace Vintage\Middleware;

use Closure;
use Illuminate\Http\Request;
use Vintage\Session;

class SessionGlobal
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!isset($GLOBALS['_SESSION'])) {
            $GLOBALS['_SESSION'] = new Session(app('session.store'));
        }

        return $next($request);
    }
}
