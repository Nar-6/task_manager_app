<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TacheController;


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
Route::get('/test', function () {
    return view('test');
});
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == "Admin") {
            return redirect()->route('admin.home');
        } else if (Auth::user()->role == "Utilisateur") {
            return redirect()->route('user.home');
        }
    }
    return view('signin');
})->name('login');

Route::post('/signin', [UserController::class,'signin'])->name('signin');
Route::group(['middleware' => 'auth'], function () {

    Route::get('/user', [UserController::class,'user_home'])->name('user.home');
    Route::put('/user/update/{id}', [UserController::class,'update'])->name('user.update');
    Route::get('/taches/encours/{num_tache}', [TacheController::class,'encours'])->name('taches.encours');
    Route::get('/taches/termine/{num_tache}', [TacheController::class,'termine'])->name('taches.termine');
    Route::delete('/user/logout', [UserController::class, 'logout'])->name('user.logout');
});

Route::group(['middleware' => ['auth','admin']], function () {

    Route::post('/admin/taches/store', [TacheController::class,'store'])->name('taches.store');
    Route::put('/admin/taches/update/{num_tache}', [TacheController::class,'update'])->name('taches.update');
    Route::delete('/admin/taches/destroy/{num_tache}', [TacheController::class,'destroy'])->name('taches.destroy');
    Route::post('/admin/users/store', [UserController::class,'store'])->name('users.store');

    Route::get('/admin/home', [UserController::class,'home'])->name('admin.home');
    Route::get('/admin/taches', [UserController::class,'taches'])->name('admin.taches');
    Route::get('/taches/high/{num_tache}', [TacheController::class,'high'])->name('taches.high');
    Route::get('/taches/medium/{num_tache}', [TacheController::class,'medium'])->name('taches.medium');
    Route::get('/taches/low/{num_tache}', [TacheController::class,'low'])->name('taches.low');
    Route::get('/admin/users', [UserController::class,'users'])->name('admin.users');
    Route::get('/admin/profile', [UserController::class,'profile'])->name('admin.profile');
    Route::get('/admin/promouvoir/{id}', [UserController::class,'promouvoir'])->name('promouvoir');
});