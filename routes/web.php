<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


//Auth

//register
Route::get('/register',[AuthController::class,'showRegister']); //menampilkan sebuah file
Route::post('/register',[AuthController::class,'register']); //mengirim data ke controller

//login
Route::get('/login',[AuthController::class,'showLogin']);
Route::post('/login',[AuthController::class,'login']);

//logout
Route::post('/logout',[AuthController::class,'logout']);


// Barang CRUD
Route::resource('barang', BarangController::class);

// Peminjaman (Inventaris)
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::put('/peminjaman/{id}/update-status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
