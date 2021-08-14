<?php

/**
 * See https://github.com/laravel/laravel/blob/8.x/config/hashing.php
 * for details of config attributes
 */

return [
    'driver' => 'bcrypt',
    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],
    'argon' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
    ],
];
