<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ee', function () {
    // this working
    dd(Auth::user());
    return "hi";
})->middleware(['auth']);
