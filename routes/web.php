<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
include ("configuration.php");

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/account', function () {
    // logic for account

    return view('accounts', []);
})->name('account');


Route::get('/login', function () {
    // extract form request inputs and sanitize
   
    return view('login', []);
})->name('login');

Route::get('/logout', function () {
    // extract form request inputs and sanitize
   
    return view('logout');
})->name('logout');

// get page
Route::get('/add_user', function () {
    // extract form request inputs and sanitize
   
    return view('add_user');
})->name('logout');
// post and redirect
Route::get('/add_user', function () {
    // extract form request inputs and sanitize
   
    return redirect('/add_user');
})->name('logout');

// get page
Route::get('/add_task', function () {
    // extract form request inputs and sanitize
   
    return view('add_task');
})->name('logout');
// post and redirect
Route::post('/add_task', function () {
    // extract form request inputs and sanitize
   
    return redirect('/add_task');
})->name('logout');