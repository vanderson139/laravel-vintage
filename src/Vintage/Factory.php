<?php

namespace Vintage;

use Illuminate\Foundation\Application;

class Factory
{
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    public function getFilePath($file): string {
        $folder_name = $this->app['config']->get('vintage.folder_name', '');
        return $this->app->basePath($folder_name . DIRECTORY_SEPARATOR . $file);
    }

    public function getRequestedFile(): string {
        $path = $this->app['request']->route('path') ?? 'index.php';

        return str_ends_with($path, '/') ? $path . 'index.php' : $path;
    }

    public function getRequestedFilePath(): string {
        return $this->getFilePath($this->getRequestedFile());
    }
}
