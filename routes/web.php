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

Route::get('/login-jurusan', function () {
    return view('admin_jurusan.login-jurusan'); 
});

Route::get('/jurusan-admin/dashboard', function () {
    return "Halaman Dashboard Jurusan sedang dibuat!";
});

Route::get('/jurusan-admin/dashboard', function () {
    return view('admin_jurusan.dashboard');
});

Route::get('/jurusan-admin/katalog', function () {
    return view('admin_jurusan.katalog');
});

Route::get('/jurusan-admin/katalog/detail', function () {
    return view('admin_jurusan.katalog-detail');
});

Route::get('/jurusan-admin/kelola-produk', function () {
    return view('admin_jurusan.kelola-produk');
});

Route::get('/jurusan-admin/kelola-jasa', function () {
    return view('admin_jurusan.kelola-jasa');
});

Route::get('/jurusan-admin/kelola-portofolio', function () {
    return view('admin_jurusan.kelola-portofolio');
});

Route::get('/jurusan-admin/kelola-deskripsi', function () {
    return view('admin_jurusan.kelola-deskripsi');
});

Route::get('/jurusan-admin/akun', function () {
    return view('admin_jurusan.akun-index');
});

Route::get('/jurusan-admin/akun/tambah', function () {
    return view('admin_jurusan.akun-create');
});

Route::get('/jurusan-admin/akun/detail', function () {
    return view('admin_jurusan.akun-detail');
});

Route::get('/jurusan-admin/akun/edit', function () {
    return view('admin_jurusan.akun-edit');
});

Route::get('/jurusan-admin/profil', function () {
    return view('admin_jurusan.profil');
});

Route::get('/login-tefa', function () {
    return view('admin_produser.login-tefa'); 
});

Route::get('/produser/dashboard', function () {
    return view('admin_produser.dashboard'); 
});

Route::get('/produser/pesanan', function () {
    return "Halaman Semua Pesanan sedang dibuat!";
});

Route::get('/produser/pesanan', function () {
    return view('admin_produser.pesanan');
});

Route::get('/produser/pesanan/detail', function () {
    return view('admin_produser.pesanan-detail');
});

Route::get('/produser/katalog', function () {
    return view('admin_produser.katalog');
});

Route::get('/produser/katalog/detail', function () {
    return view('admin_produser.katalog-detail');
});

Route::get('/produser/profil', function () {
    return view('admin_produser.profil');
});