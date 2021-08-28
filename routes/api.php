<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CardVersionController;

Route::post('/cards/{cardId}/versions/{versionId}', [
    CardVersionController::class,
    'postIndex',
]);

Route::get('/cards/{cardId}/versions/{versionId}/scrape-value', [
    CardVersionController::class,
    'getScrapeValue',
]);
