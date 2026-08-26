<?php

use Illuminate\Support\Facades\Route;

// Halaman utama (Login)
Route::get('/', function () {
    return view('login');
});

// Route simulasi untuk dashboard nanti
Route::get('/dashboard', function () {
    return "Halaman Dashboard akan dibuat selanjutnya!";
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/pesanan', function () {
    // Tambahkan 'pesanan.' di depan 'index'
    return view('pesanan.index'); 
});

Route::get('/pesanan/detail', function () {
    return view('pesanan.detail');
});

Route::get('/jurusan', function () {
    return view('jurusan.index');
});

// Halaman Daftar Akun
Route::get('/akun', function () {
    return view('akun.index');
});

// Halaman Tambah Akun
Route::get('/akun/tambah', function () {
    return view('akun.create');
});

Route::get('/akun/detail', function () {
    return view('akun.detail');
});

Route::get('/akun/edit', function () {
    return view('akun.edit');
});

Route::get('/profil', function () {
    return view('profil.index');
});

Route::get('/faq', function () {
    return view('faq.index');
});