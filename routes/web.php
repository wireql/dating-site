<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;
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
// Route::get('migrate',function(){
//     Artisan::call('migrate');
// });  

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [IndexController::class, 'create'])->name('index');
    
    Route::get('/profile', [ProfileController::class, 'create'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');

    Route::get('/profile/favourites', [ProfileController::class, 'favourites'])->name('profile.favourites');
    Route::post('/profile/favourites/add', [ProfileController::class, 'addFavourites'])->name('profile.favourites-add');

    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

    Route::get('/profile/{id}', [UserProfileController::class, 'create'])->name('user');

});