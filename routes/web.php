<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['oke' => 2]);
    // return view('welcome');
});

Route::get('/aa', function () {
    return response()->json(['aa' => 2]);
    // return view('welcome');
});
