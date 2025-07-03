<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [BlogController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('register', [UserController::class, 'create'])->name('register.form');
Route::post('register', [UserController::class, 'store'])->name('register.store');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
});


Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy')->middleware('auth');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/blogs', [AdminController::class, 'index'])-> name('admin.blogs');
    Route::get('/admin/blogs/{blog}/edit', [AdminController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/admin/blogs/{blog}', [AdminController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/admin/blogs/{blog}', [AdminController::class, 'destroy'])->name('admin.blogs.destroy');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/admin/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

Route::post('/blogs/{id}/like', [BlogController::class, 'ajaxToggleLike'])
    ->name('blogs.like.ajax')->middleware('auth');