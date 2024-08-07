<?php

use App\Http\Controllers\Demo\DemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/about', function () {
//     return view('about');
// });

Route::controller(DemoController::class)->group(function () {
    // Route::get('/about', 'index');
    Route::get('/about', 'index')->name('about.page');
    Route::get('/contact', 'contact')->name('contact.page');
});
