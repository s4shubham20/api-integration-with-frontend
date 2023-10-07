<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginUserController;


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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('login',[LoginUserController::class, 'index'])->name('apilogin');
Route::post('login',[LoginUserController::class, 'store'])->name('apilogin');
Route::group(['middleware' => 'isAdmin', 'prefix'   => 'admin'],function(){
    Route::get('userdetails', [LoginUserController::class, 'userdetails']);
    Route::resource('dashboard', AdminController::class);
    Route::post('logout', [LoginUserController::class, 'logout']);
});
