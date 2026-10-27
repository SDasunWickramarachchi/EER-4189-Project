<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/services', function () {
    return view('services');

});

Route::get('/booking', function () {
    return view('booking');
});

//admin pages
Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::get('/admin/forgot-password', function () {
    return view('admin.forgot-password');
});