<?php namespace Vintage;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index(Factory $factory) {
        ob_start();

        require_once $factory->getRequestedFilePath();
        $result = ob_get_contents();

        ob_end_clean();

        return $result;
    }
}
