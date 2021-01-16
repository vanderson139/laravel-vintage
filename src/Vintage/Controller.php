<?php namespace Vintage;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected $path = '';

    protected $file = '';

    protected $filePath = '';

    public function __construct()
    {
        $this->path = realpath(config('vintage.path', ''));
    }

    public function index(Request $request)
    {
        $this->file = $request->path() == '/' ? 'index.php' : $request->path();

        ob_start();

        require_once $this->getFilePath();
        $result = ob_get_contents();

        ob_end_clean();

        return $result;
    }

    protected function getFilePath(): string
    {
        return realpath($this->path . DIRECTORY_SEPARATOR . $this->file);
    }
}