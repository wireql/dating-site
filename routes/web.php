<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDatasController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileOpenInfoController;
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
    Route::get('/profile/recomendations', [ProfileController::class, 'recomendations'])->name('profile.recomendations');
    Route::post('/profile/favourites/add', [ProfileController::class, 'addFavourites'])->name('profile.favourites-add');

    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

    Route::get('/profile/{id}', [UserProfileController::class, 'create'])->name('user');
    Route::post('/profile/{id}', [ProfileOpenInfoController::class, 'store'])->name('user.open');

    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin');
    Route::get('/admin/users', [AdminUsersController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{id}', [AdminUsersController::class, 'show'])->name('admin.user');
    Route::delete('/admin/users/{id}', [AdminUsersController::class, 'delete'])->name('admin.user.delete');
    Route::post('/admin/users/{id}', [AdminUsersController::class, 'update'])->name('admin.user.update');
    Route::put('/admin/users/{id}', [AdminUsersController::class, 'add'])->name('admin.user.add');

    Route::get('/admin/datas', [AdminDatasController::class, 'index'])->name('admin.datas');
    Route::post('/admin/datas/hobby', [AdminDatasController::class, 'create_hobby'])->name('admin.datas.hobby.add');
    Route::post('/admin/datas/hobby/{id}', [AdminDatasController::class, 'action_hobby'])->name('admin.datas.hobby');

    Route::post('/admin/datas/preferences', [AdminDatasController::class, 'create_preferences'])->name('admin.datas.preferences.add');
    Route::post('/admin/datas/preferences/{id}', [AdminDatasController::class, 'action_preferences'])->name('admin.datas.preferences');

    Route::post('/admin/datas/parents', [AdminDatasController::class, 'create_parents'])->name('admin.datas.parents.add');
    Route::post('/admin/datas/parents/{id}', [AdminDatasController::class, 'action_parents'])->name('admin.datas.parents');
});