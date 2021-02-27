<?php

Route::middleware('vintage')
    ->any('/{path?}', ['as' => 'vintage', 'uses' => '\Vintage\Controller@index'])
    ->where('path', '.*');
