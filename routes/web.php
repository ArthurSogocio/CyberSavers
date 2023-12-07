<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('/home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* player resource routes */
Route::view('/dice_stats', 'resources/dice_stats')->name('dice_stats')->middleware('auth');

Auth::routes();

/* user routes */
Route::view('/manage_users', 'users/manage_users')->name('manage_users')->middleware('auth');

Route::view('/add_user', 'users/add_user')->name('add_user')->middleware('auth');

Route::get('ajax/getusers', [UserController::class, 'getUsers'])->name('ajax.getusers')->middleware('auth');
//user management
Route::post('/user/add', [UserController::class, 'addUser'])->middleware('auth');

Route::get('/user/{uid}/details/', function ($uid) {
    return view('users/user_details')->with('uid', $uid);
})->middleware('auth');

Route::get('/user/{uid}/builder/', function ($uid) {
    return view('users/builder')->with('uid', $uid);
})->middleware('auth');

/*Route::post('/historical_products_flag_report/{id}/edit/{edit}', function($id, $edit) {
    return view('historical_products_flag_editproduct')
                    ->with('id', $id)
                    ->with('edit', $edit);
})->middleware('auth');*/
/* builder routes */
Route::post('/builder', [UserController::class, 'buildUser'])->name('builder')->middleware('auth');