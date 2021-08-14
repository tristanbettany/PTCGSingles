<?php

/**
 * See https://github.com/laravel/laravel/blob/8.x/config/view.php
 * for details of config attributes
 */

return [
    'paths' => [
        resource_path('views'),
    ],
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),
];
