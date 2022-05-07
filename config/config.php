<?php

defined('ROOT') ?: define('ROOT', dirname(__DIR__));

if (file_exists(ROOT . '/.env')) {
    $dotEnv = new Dotenv\Dotenv(ROOT);
    $dotEnv->load();
}

return [
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === 'true',
        'addContentLengthHeader' => false,
        'app' => [
            'name' => getenv('APP_NAME'),
            'url'  => getenv('APP_URL'),
            'env'  => getenv('APP_ENV')
        ],

        'database' => [
            'password'  => getenv('DB_PASSWORD'),
            'database'  => getenv('DB_DATABASE'),
            'charset'   => 'utf8',

            'prefix'    => '',
            'driver'    => getenv('DB_CONNECTION'),
            'host'      => getenv('DB_HOST'),

            'username'  => getenv('DB_USERNAME'),
            'port'      => getenv('DB_PORT'),
        ],

        'thecatapi'=> [
            'apiKey'	=> getenv('THE_CAT_API_KEY'),
            'apiUrl'	=> getenv('THE_CAT_API_URL')
        ],
        'cors' => null !== getenv('CORS_ALLOWED_ORIGINS') ? getenv('CORS_ALLOWED_ORIGINS') : '*'
    ],
];