<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('/home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* player resource routes */
Route::view('/dice_stats', 'player_resources/dice_stats')->name('dice_stats')->middleware('auth');

/* admin routes */
Route::view('/manage_users', 'admin/manage_users')->name('manage_users')->middleware('auth');
Auth::routes();

Route::get('ajax/getusers', [AdminController::class, 'getUsers'])->name('ajax.getusers')->middleware('auth');
Route::get('/user/{uid}/details/', function ($uid) {
    return view('admin/user_details')->with('uid', $uid);
})->middleware('auth');
