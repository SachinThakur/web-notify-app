<?php

 use App\Http\Controllers\DashboardController;
 use App\Http\Controllers\UserController;
 use App\Http\Controllers\ProfileController;
 use App\Http\Controllers\NotificationController;
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

Route::get('/', function () {
    return view('welcome');
});

// Redirect from /home to /dashboard
Route::get('/home', function () {
    return redirect()->route('dashboard');
});

Auth::routes();
Route::impersonate();

// App Routes

Route::get('/dashboard', [DashboardController::class,'show'])->name('dashboard');

// Users
Route::get('/users', [UserController::class,'index'])->name('user.index');
Route::get('/users/create', [UserController::class,'create'])->name('user.create');
Route::post('/users/create', [UserController::class,'store'])->name('user.store');
Route::get('/users/{user}', [UserController::class,'edit'])->name('user.edit');
Route::patch('/users/{user}', [UserController::class,'update'])->name('user.update');
Route::delete('/users/{user}', [UserController::class,'destroy'])->name('user.destroy');


// Notifications
Route::get('/notifications', [NotificationController::class,'index'])->name('notification.index');
Route::get('/notifications/create', [NotificationController::class,'create'])->name('notification.create');
Route::post('/notifications/create', [NotificationController::class,'store'])->name('notification.store');
Route::get('/notifications/{user}', [NotificationController::class,'edit'])->name('notification.edit');
Route::post('/mark-as-read', [NotificationController::class,'markNotification'])->name('markNotification');

// Profile
Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class,'update'])->name('profile.update');