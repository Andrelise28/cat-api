<?php
const SETTINGS='settings';
const DATABASE='database';

$config = require __DIR__ . '/config/config.php';

return [
    'paths' => [
        'migrations'=>'%%PHINX_CONFIG_DIR%%/app/Migrations'
    ],
    'environments' => [
        'default_database' => 'default',
        'default' => [
            'name' => $config[SETTINGS][DATABASE][DATABASE],
            'adapter' => $config[SETTINGS][DATABASE]['driver'],
            'host' => $config[SETTINGS][DATABASE]['host'],
            'user' => $config[SETTINGS][DATABASE]['username'],
            'pass' => $config[SETTINGS][DATABASE]['password'],
            'port' => $config[SETTINGS][DATABASE]['port'],
            'charset' => $config[SETTINGS][DATABASE]['charset'],
        ]
    ]
];