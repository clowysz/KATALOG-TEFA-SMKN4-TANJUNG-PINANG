<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jurusan;

class AkunController extends Controller
{
    // Menampilkan daftar akun Admin Jurusan
    public function index()
    {
        $adminJurusans = User::where('role', 'admin_jurusan')
            ->with('jurusanDipegang')
            ->get();

        return view('admin.admin_tefa.akun.index', compact('adminJurusans'));
    }

    // Menampilkan form tambah akun Admin Jurusan
    public function create()
    {
        // Hanya jurusan yang BELUM punya admin_jurusan
        // yang boleh dipilih (mencegah 1 jurusan dipegang 2 admin)
        $jurusanKosong = Jurusan::whereDoesntHave('adminJurusan')
            ->get();

        return view('admin.admin_tefa.akun.create', compact('jurusanKosong'));
    }

    // Menyimpan akun Admin Jurusan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan',
        ]);

        // Pastikan jurusan yang dipilih belum punya admin_jurusan
        $jurusan = Jurusan::findOrFail($request->id_jurusan);

        if ($jurusan->id_user) {
            return redirect()->back()->withErrors([
                'error' => 'Jurusan ini sudah memiliki Admin Jurusan.'
            ]);
        }

        // Buat akun Admin Jurusan
        $adminJurusan = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_jurusan',
        ]);

        // Hubungkan jurusan ke akun yang baru dibuat
        $jurusan->update([
            'id_user' => $adminJurusan->id,
        ]);

        return redirect('/akun')->with(
            'success',
            'Admin Jurusan berhasil ditambahkan.'
        );
    }
}