<?php

require __DIR__.DS.'..'.DS.'vendor'.DS.'autoload.php';

Flight::register(
    'db',
    \flight\database\PdoWrapper::class,
    ['mysql:host='.env('DB_HOST').';dbname='.env('DB_DATABASE'),
        env('DB_USERNAME'),
        env('DB_PASSWORD'),
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8mb4\'',
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ],
    ]
);

$route = Flight::router();

require __DIR__.DS.'..'.DS.'routes'.DS.'api.php';

require __DIR__.DS.'..'.DS.'routes'.DS.'web.php';

//Handle 404 errors
$route->map('*', function () {
    abort(404);
});

Flight::start();
