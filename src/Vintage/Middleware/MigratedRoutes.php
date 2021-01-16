<?php

namespace ItsSeg\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MigratedRoutes
{
    protected $redirectTo;

    protected $routes;

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->routes = config('vintage.migrated_routes', []);

        $path = $request->path() == '/' ? 'index.php' : $request->path();

        if($this->canRedirect($path)) {
            return redirect()->route($this->redirectTo, $request->query());
        }

        $this->abortIfNotExists($path);

        return $next($request);
    }

    protected function abortIfNotExists($path)
    {
        $filePath = realpath(config('vintage.path', '') . $path);

        if(!file_exists($filePath)) {
            abort(Response::HTTP_NOT_FOUND);
        }
    }

    protected function canRedirect($path)
    {
        return $this->redirectTo = $this->routes[$path] ?? '';
    }
}