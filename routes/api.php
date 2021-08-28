<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CardVersionController;

Route::post('/cards/{cardId}/versions/{versionId}', [
    CardVersionController::class,
    'postIndex',
]);
