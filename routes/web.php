<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ListingController::class, 'index'])->name('home');
// Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/manage', [ListingController::class, 'manage'])->name('listings.manage')->middleware('auth');

Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create')->middleware('auth');
Route::post('/listings/store', [ListingController::class, 'store'])->name('listings.store')->middleware('auth');

Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit')->middleware('auth');
Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update')->middleware('auth');
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy')->middleware('auth');


// Route::resource('listings', ListingController::class)->only([
//     'create', 'store', 'edit', 'update', 'destroy'
// ]);

use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('optimize:clear');
    return response('Xoa thanh cong');
});

Route::get('/register', [UserController::class, 'register'])->name('users.register')->middleware('guest');
Route::post('/register', [UserController::class, 'store'])->name('users.store');

Route::get('/login', [UserController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->name('users.login');

Route::post('/logout', [UserController::class, 'logout']);
