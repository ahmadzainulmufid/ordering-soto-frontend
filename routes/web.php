<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', fn() => view('auth.login'));
Route::get('/register', fn() => view('auth.register'));
Route::get('/profile', fn() => view('profile'));
Route::get('/dashboard', fn() => view('dashboard'));

Route::get('/', fn() => redirect('/login'));