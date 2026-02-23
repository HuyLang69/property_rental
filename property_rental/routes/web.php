<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/listings', function () {
    return view('listings.index');
});

Route::get('/listings/{id}', function ($id) {
    return view('listings.show');
});