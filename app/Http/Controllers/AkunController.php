<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Jurusan;

class AkunController extends Controller
{
    // =========================================================
    // DAFTAR AKUN
    // =========================================================

    public function index()
    {
        // Hanya tampilkan akun internal:
        // Admin TEFA dan Admin Jurusan
        $akuns = User::whereIn('role', [
            'admin_tefa',
            'admin_jurusan',
        ])
        ->with('jurusanDipegang')
        ->get();

        return view(
            'admin.admin_tefa.akun.index',
            compact('akuns')
        );
    }


    // =========================================================
    // FORM TAMBAH AKUN
    // =========================================================

    public function create()
    {
        // Hanya jurusan yang belum memiliki Admin Jurusan
        // yang dapat dipilih.
        $jurusanKosong = Jurusan::whereNull('id_user')->get();

        return view(
            'admin.admin_tefa.akun.create',
            compact('jurusanKosong')
        );
    }


    // =========================================================
    // SIMPAN AKUN BARU
    // =========================================================

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin_tefa',
                    'admin_jurusan',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'tidak_aktif',
                ]),
            ],

            'id_jurusan' => [
                'nullable',
                'exists:jurusan,id_jurusan',
                'required_if:role,admin_jurusan',
            ],
        ]);


        // =====================================================
        // JIKA ROLE ADMIN JURUSAN
        // =====================================================

        if ($request->role === 'admin_jurusan') {

            $jurusan = Jurusan::findOrFail(
                $request->id_jurusan
            );

            // Satu jurusan hanya boleh memiliki
            // satu Admin Jurusan.
            if ($jurusan->id_user) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'id_jurusan' =>
                            'Jurusan ini sudah memiliki Admin Jurusan.'
                    ]);
            }


            // Buat akun Admin Jurusan
            $akun = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin_jurusan',
                'status' => $request->status,
            ]);


            // Hubungkan jurusan dengan akun tersebut
            $jurusan->update([
                'id_user' => $akun->id,
            ]);

        } else {

            // =================================================
            // JIKA ROLE ADMIN TEFA
            // =================================================

            // Admin TEFA tidak terikat jurusan.
            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin_tefa',
                'status' => $request->status,
            ]);
        }


        return redirect()
            ->route('akun.index')
            ->with(
                'success',
                'Akun berhasil ditambahkan.'
            );
    }


    // =========================================================
    // DETAIL AKUN
    // =========================================================

    public function show($id)
    {
        $akun = User::whereIn('role', [
            'admin_tefa',
            'admin_jurusan',
        ])
        ->with('jurusanDipegang')
        ->findOrFail($id);

        return view(
            'admin.admin_tefa.akun.detail',
            compact('akun')
        );
    }


    // =========================================================
    // FORM EDIT AKUN
    // =========================================================

    public function edit($id)
    {
        $akun = User::whereIn('role', [
            'admin_tefa',
            'admin_jurusan',
        ])
        ->with('jurusanDipegang')
        ->findOrFail($id);

        // Jurusan yang belum memiliki Admin Jurusan.
        // Jurusan milik akun yang sedang diedit juga
        // tetap dimasukkan.
        $jurusanKosong = Jurusan::where(function ($query) use ($akun) {

            $query->whereNull('id_user');

            if ($akun->jurusanDipegang) {
                $query->orWhere(
                    'id_jurusan',
                    $akun->jurusanDipegang->id_jurusan
                );
            }

        })->get();

        return view(
            'admin.admin_tefa.akun.edit',
            compact(
                'akun',
                'jurusanKosong'
            )
        );
    }


    // =========================================================
    // UPDATE AKUN
    // =========================================================

    public function update(Request $request, $id)
    {
        $akun = User::whereIn('role', [
            'admin_tefa',
            'admin_jurusan',
        ])->findOrFail($id);


        $request->validate([
            'nama' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($akun->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin_tefa',
                    'admin_jurusan',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'tidak_aktif',
                ]),
            ],

            'id_jurusan' => [
                'nullable',
                'exists:jurusan,id_jurusan',
                'required_if:role,admin_jurusan',
            ],
        ]);


        // =====================================================
        // LEPAS JURUSAN LAMA
        // =====================================================

        $jurusanLama = $akun->jurusanDipegang;


        if ($jurusanLama) {
            $jurusanLama->update([
                'id_user' => null,
            ]);
        }


        // =====================================================
        // UPDATE DATA USER
        // =====================================================

        $akun->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);


        // =====================================================
        // JIKA MENJADI ADMIN JURUSAN
        // =====================================================

        if ($request->role === 'admin_jurusan') {

            $jurusanBaru = Jurusan::findOrFail(
                $request->id_jurusan
            );


            // Pastikan jurusan tersebut tidak sedang
            // dimiliki Admin Jurusan lain.
            if (
                $jurusanBaru->id_user &&
                $jurusanBaru->id_user != $akun->id
            ) {

                // Kembalikan jurusan lama jika ada.
                if ($jurusanLama) {
                    $jurusanLama->update([
                        'id_user' => $akun->id,
                    ]);
                }

                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'id_jurusan' =>
                            'Jurusan ini sudah memiliki Admin Jurusan.'
                    ]);
            }


            $jurusanBaru->update([
                'id_user' => $akun->id,
            ]);
        }


        return redirect()
            ->route('akun.index')
            ->with(
                'success',
                'Data akun berhasil diperbarui.'
            );
    }


    // =========================================================
    // UBAH STATUS AKUN
    // =========================================================

    public function updateStatus(Request $request, $id)
    {
        $akun = User::whereIn('role', [
            'admin_tefa',
            'admin_jurusan',
        ])->findOrFail($id);


        $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'tidak_aktif',
                ]),
            ],
        ]);


        $akun->update([
            'status' => $request->status,
        ]);


        return redirect()
            ->back()
            ->with(
                'success',
                'Status akun berhasil diperbarui.'
            );
    }


    // =========================================================
    // RESET PASSWORD
    // =========================================================

    public function resetPassword(Request $request, $id)
    {
        $akun = User::whereIn('role', [
            'admin_tefa',
            'admin_jurusan',
        ])->findOrFail($id);


        $request->validate([
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);


        $akun->update([
            'password' => Hash::make(
                $request->password
            ),
        ]);


        return redirect()
            ->back()
            ->with(
                'success',
                'Password akun berhasil diubah.'
            );
    }
}