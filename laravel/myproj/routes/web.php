<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplicationController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login.submit');

Route::get('/register',[AuthController::class,'showRegister'])->name('register');
Route::post('/register',[AuthController::class,'register'])->name('register.submit');

Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/calculator',function(){
    return view('calculator');
})->name('calculator');

Route::middleware(['auth'])->group(function () {
    Route::get('/jobApplication', [JobApplicationController::class,'showJobApplication'])->name('jobApplication');
    Route::post('/jobapplication',[JobApplicationController::class,'submit'])->name('jobApplication.submit');
    Route::get('/jobapplicationList',[JobApplicationController::class,'listJobApplication'])->name('jobApplication.list');
    Route::delete('/jobapplication/{id}',[JobApplicationController::class,'delete'])->name('jobApplication.delete');
    Route::get('/jobapplication/{id}',[JobApplicationController::class,'showUpdate'])->name('jobApplication.update');
    Route::post('/jobapplication/{id}',[JobApplicationController::class,'update'])->name('jobApplication.up');
});