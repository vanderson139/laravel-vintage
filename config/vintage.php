<?php

return [
    'folder_name' => 'vintage',
    'middlewares' => [
        \Vintage\Middleware\MigratedRoutes::class,
        \Vintage\Middleware\SessionGlobal::class
    ],
    'migrated_routes' => []
];
