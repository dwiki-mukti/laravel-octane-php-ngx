<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/now', function () {
    return response()->json(['now' => time()]);
});
