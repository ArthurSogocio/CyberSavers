<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* player resource routes */
Route::view('/dice_stats', 'player_resources/dice_stats')->name('dice_stats')->middleware('auth');

/* admin routes */
Route::view('/manage_users', 'admin/manage_users')->name('manage_users')->middleware('auth');