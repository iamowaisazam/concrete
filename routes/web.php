<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Broadcast::routes(['middleware' => ['auth:sanctum']]);
// ya agar session auth use kar rahe ho to
Broadcast::routes(['middleware' => ['auth']]);


Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.*');

