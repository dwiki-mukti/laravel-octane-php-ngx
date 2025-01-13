<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'hello world!']);
});

Route::get('/now', function () {
    return response()->json(['now' => time()]);
});
