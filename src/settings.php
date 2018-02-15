<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true,

        // App Profile
        'app_profile' => [
            'name' => 'Hospitality Platform',
            'author' => 'Harmoni Permana',
            'description' => 'Platform yang membantu untuk mengelola operasional dari kegiatan Hospitality.',
            'developer' => 'KULKUL.ID',
        ],

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__.'/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        // Database settings
        'database' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'Rentcar',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ],

        'encrypt' => [
            'key' => md5('kulkul.id'),
        ],
    ],
];
