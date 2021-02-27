<?php

namespace Vintage;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getRequestedFilePath()
 * @method static string getRequestedFile()
 * @method static string getFilePath(string $file)
 *
 * @see \Vintage\Factory
 */
class Vintage extends Facade
{

    protected static function getFacadeAccessor() {
        return 'vintage';
    }

}
