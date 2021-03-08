# laravel-vintage
Runs legacy code inside a Laravel project

## Why?
To help and endorse legacy projects upgrade to a modern platform, allowing routes to be migrated gradativelly and, in the meanwhile, making it a fun process.

## Installation

1 - Create a new laravel project

```shell
composer create-project --prefer-dist laravel/laravel {projectName} "5.8.*"
```

2 - Require via Composer

```shell
composer create-project vanderson139/laravel-vintage
```

3 - Get configuration file 
```shell
php artisan vendor:publish
```

4 - Put your legacy project inside `./vintage` folder.

## How It Works?

When laravel gets a request, it first will attempt to find a route for it. Then, if there's none, tries to load a file from `vintage` folder. 

After migrate any route from legacy php files to a laravel controller, place it's path into `migrated_routes` in config file.

## Personalization

Your project may not run perfectly out of the box. In this cases, is possible do add new middlewares to make any adjustments you need. 
Just make sure to place them into config file.

```php
<?php

return [
    'folder_name' => 'vintage',
    'middlewares' => [
        \Vintage\Middleware\MigratedRoutes::class,
        \Vintage\Middleware\SessionGlobal::class,
        \Project\MyCustomMiddleware\AjustCustomBehavior::class,
    ],
    'migrated_routes' => [
        'my_legacy_file.php' => '/laravel-route'
    ]
];
```

## Known Issues

Global variables calls will not work, replace them with global $GLOBALS.

Replace this:
```php
global $MY_GLOBAL_VARIABLE;
```
With this:
```php
$GLOBALS['MY_GLOBAL_VARIABLE'];
```