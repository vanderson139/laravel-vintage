<?php namespace Vintage;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index(Request $request)
    {
        $file = $request->route('path') ?? 'index.php';

        ob_start();

        require_once $this->getFilePath($file);
        $result = ob_get_contents();

        ob_end_clean();

        return $result;
    }

    protected function getFilePath($file): string
    {
        $folder_name = config('vintage.folder_name', '');
        return base_path($folder_name . DIRECTORY_SEPARATOR . $file);
    }
}
