<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.login.login');
});

Route::get('/dashboard', function () {
    return view('admin.admin_tefa.dashboard');
});

Route::get('/pesanan', function () {
    return view('admin.admin_tefa.pesanan.index'); 
});

Route::get('/pesanan/detail', function () {
    return view('admin.admin_tefa.pesanan.detail');
});

Route::get('/jurusan', function () {
    return view('admin.admin_tefa.jurusan.index');
});


Route::get('/akun', function () {
    return view('admin.admin_tefa.akun.index');
});


Route::get('/akun/tambah', function () {
    return view('admin.admin_tefa.akun.create');
});

Route::get('/akun/detail', function () {
    return view('admin.admin_tefa.akun.detail');
});

Route::get('/akun/edit', function () {
    return view('admin.admin_tefa.akun.edit');
});

Route::get('/profil', function () {
    return view('admin.admin_tefa.profil.index');
});

Route::get('/faq', function () {
    return view('admin.admin_tefa.faq.index');
});

// RUTE ADMIN JURUSAN

Route::get('/login-jurusan', function () {
    return view('admin.admin_jurusan.login-jurusan'); 
});

Route::get('/jurusan-admin/dashboard', function () {
    return view('admin.admin_jurusan.dashboard');
});

Route::get('/jurusan-admin/katalog', function () {
    return view('admin.admin_jurusan.katalog');
});

Route::get('/jurusan-admin/katalog/detail', function () {
    return view('admin.admin_jurusan.katalog-detail');
});

Route::get('/jurusan-admin/kelola-produk', function () {
    return view('admin.admin_jurusan.kelola-produk');
});

Route::get('/jurusan-admin/kelola-jasa', function () {
    return view('admin.admin_jurusan.kelola-jasa');
});

Route::get('/jurusan-admin/kelola-portofolio', function () {
    return view('admin.admin_jurusan.kelola-portofolio');
});

Route::get('/jurusan-admin/kelola-deskripsi', function () {
    return view('admin.admin_jurusan.kelola-deskripsi');
});

Route::get('/jurusan-admin/akun', function () {
    return view('admin.admin_jurusan.akun-index');
});

Route::get('/jurusan-admin/akun/tambah', function () {
    return view('admin.admin_jurusan.akun-create');
});

Route::get('/jurusan-admin/akun/detail', function () {
    return view('admin.admin_jurusan.akun-detail');
});

Route::get('/jurusan-admin/akun/edit', function () {
    return view('admin.admin_jurusan.akun-edit');
});

Route::get('/jurusan-admin/profil', function () {
    return view('admin.admin_jurusan.profil');
});

// RUTE ADMIN PRODUK/JASA (PRODUSER)

Route::get('/login-tefa', function () {
    return view('admin.login.login-tefa'); 
});

Route::get('/produser/dashboard', function () {
    return view('admin.admin_produser.dashboard'); 
});

Route::get('/produser/pesanan', function () {
    return view('admin.admin_produser.pesanan');
});

Route::get('/produser/pesanan/detail', function () {
    return view('admin.admin_produser.pesanan-detail');
});

Route::get('/produser/katalog', function () {
    return view('admin.admin_produser.katalog');
});

Route::get('/produser/katalog/detail', function () {
    return view('admin.admin_produser.katalog-detail');
});

Route::get('/produser/profil', function () {
    return view('admin.admin_produser.profil');
});