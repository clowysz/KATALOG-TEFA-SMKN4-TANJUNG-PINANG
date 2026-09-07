<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    // =========================
    // DAFTAR AKUN
    // =========================
    public function index()
    {
        $akuns = Akun::all();

        return view('akun.index', compact('akuns'));
    }


    // =========================
    // TAMBAH AKUN
    // =========================
    public function create()
    {
        return view('akun.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:akuns,email',
            'password' => 'required|min:8',
            'role' => 'required',
            'jurusan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Akun::create([
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'jurusan' => $request->jurusan,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('akun.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }


    // =========================
    // LIHAT DETAIL
    // =========================
    public function show($id)
    {
        $akun = Akun::findOrFail($id);

        return view('akun.detail', compact('akun'));
    }


    // =========================
    // EDIT AKUN
    // =========================
    public function edit($id)
    {
        $akun = Akun::findOrFail($id);

        return view('akun.edit', compact('akun'));
    }


    // =========================
    // UPDATE AKUN
    // =========================
    public function update(Request $request, $id)
    {
        $akun = Akun::findOrFail($id);

        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:akuns,email,' . $akun->id,
            'role' => 'required',
            'jurusan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $akun->update([
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'role' => $request->role,
            'jurusan' => $request->jurusan,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('akun.show', $akun->id)
            ->with('success', 'Data akun berhasil diperbarui.');
    }


    // =========================
    // RESET PASSWORD
    // =========================
    public function resetPassword(Request $request, $id)
    {
        $akun = Akun::findOrFail($id);

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $akun->password = Hash::make($request->password);
        $akun->save();

        return redirect()
            ->route('akun.show', $akun->id)
            ->with('success', 'Password berhasil direset.');
    }


    // =========================
    // HAPUS AKSES
    // =========================
    public function hapusAkses($id)
    {
        $akun = Akun::findOrFail($id);

        $akun->status = 'nonaktif';
        $akun->save();

        return redirect()
            ->route('akun.index')
            ->with('success', 'Akses akun berhasil dinonaktifkan.');
    }
}