<?php

namespace Vintage\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MigratedRoutes
{
    protected $redirect_to;

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

        $path = $request->route('path') ?? 'index.php';

        if($this->canRedirect($path)) {
            return redirect()->route($this->redirect_to, $request->query());
        }

        $this->abortIfNotExists($path);

        return $next($request);
    }

    protected function abortIfNotExists(string $file)
    {
        $file_path = $this->getFilePath($file);

        if(!file_exists($file_path)) {
            abort(Response::HTTP_NOT_FOUND);
        }
    }

    protected function getFilePath($file): string
    {
        $folder_name = config('vintage.folder_name', '');
        return base_path($folder_name . DIRECTORY_SEPARATOR . $file);
    }

    protected function canRedirect($path)
    {
        return $this->redirect_to = $this->routes[$path] ?? '';
    }
}
