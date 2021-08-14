<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RootController;

Route::get('/', [
    RootController::class,
    'getIndex',
])->name('root');
