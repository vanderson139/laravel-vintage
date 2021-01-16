<?php namespace Vintage\Middleware;

use Closure;
use Illuminate\Http\Request;
use Vintage\Session;

class Setup
{
    protected $redirectTo;

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(config('vintage.disable_error_reporting')) {
            $this->setErrorReportingConfig();
        }
        
        $this->setIncludePath();
        $this->fixGlobals();

        return $next($request);
    }

    protected function setErrorReportingConfig(): void
    {
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    }

    protected function setIncludePath(): void
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . config('vintage.path'));
    }

    protected function fixGlobals()
    {
        if(config('vintage.enable_session_global')) {
            if (!isset($GLOBALS['_SESSION'])) {
                $GLOBALS['_SESSION'] = new Session(app('session.store'));
            }
        }

        if(!empty($_SERVER['REQUEST_URI'])) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            $_SERVER['PHP_SELF'] = isset($url['path']) ? $url['path'] : '/index.php';
        }
    }
}