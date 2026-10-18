<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Jurusan;

class AkunController extends Controller
{
    // =========================================================
    // ATURAN JURUSAN (1 jurusan = 1 Admin Jurusan aktif)
    // =========================================================

    /**
     * Daftar jurusan yang boleh dipilih pada form.
     *
     * Sebuah jurusan boleh dipilih jika:
     *  - belum memiliki Admin Jurusan, atau
     *  - Admin Jurusan-nya berstatus tidak aktif, atau
     *  - jurusan itu milik akun yang sedang diedit ($akun).
     */
    private function jurusanTersedia(?User $akun = null)
    {
        return Jurusan::with('user:id,nama,status')
            ->where(function ($query) use ($akun) {

                $query->whereDoesntHave('user')
                    ->orWhereHas('user', function ($user) {
                        $user->where('status', 'tidak_aktif');
                    });

                if ($akun) {
                    $query->orWhere('id_user', $akun->id);
                }

            })
            ->orderBy('nama_jurusan')
            ->get();
    }


    /**
     * Pemeriksaan di sisi server (dropdown saja tidak cukup).
     * Aturannya sama dengan jurusanTersedia().
     */
    private function jurusanBisaDipakai(Jurusan $jurusan, ?int $akunId = null): bool
    {
        // Belum punya admin
        if (!$jurusan->id_user) {
            return true;
        }

        // Admin-nya adalah akun itu sendiri
        if ($akunId && (int) $jurusan->id_user === $akunId) {
            return true;
        }

        // Admin lama sudah tidak ada, atau berstatus tidak aktif
        $pemegang = $jurusan->user;

        return !$pemegang || $pemegang->status === 'tidak_aktif';
    }


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
        // Jurusan yang belum punya admin, atau adminnya nonaktif.
        $jurusanKosong = $this->jurusanTersedia();

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
                'exists:jurusans,id_jurusan',
                'required_if:role,admin_jurusan',
            ],
        ]);


        // =====================================================
        // JIKA ROLE ADMIN JURUSAN
        // =====================================================

        if ($request->role === 'admin_jurusan') {

            $jurusan = Jurusan::with('user')->findOrFail(
                $request->id_jurusan
            );

            // Satu jurusan hanya boleh memiliki satu Admin Jurusan
            // yang aktif. Jurusan dengan admin nonaktif boleh diambil alih.
            if (!$this->jurusanBisaDipakai($jurusan)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'id_jurusan' =>
                            'Jurusan ini sudah memiliki Admin Jurusan yang aktif.'
                    ]);
            }

            // Admin lama (nonaktif) yang akan digantikan, jika ada
            $adminLama = $jurusan->user;

            DB::transaction(function () use ($request, $jurusan) {

                // Buat akun Admin Jurusan
                $akun = User::create([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'admin_jurusan',
                    'status' => $request->status,
                ]);

                // Hubungkan jurusan dengan akun baru. Karena relasinya
                // satu kolom (jurusans.id_user), admin lama otomatis
                // tidak lagi memegang jurusan ini.
                $jurusan->update([
                    'id_user' => $akun->id,
                ]);
            });

            $pesan = 'Akun berhasil ditambahkan.';

            if ($adminLama) {
                $pesan .= ' Admin sebelumnya (' . $adminLama->nama
                    . ') tidak lagi memegang jurusan ini.';
            }

            return redirect()
                ->route('akun.index')
                ->with('success', $pesan);
        }


        // =====================================================
        // JIKA ROLE ADMIN TEFA
        // =====================================================

        // Admin TEFA tidak terikat jurusan.
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_tefa',
            'status' => $request->status,
        ]);


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

        // Jurusan yang belum punya admin, atau adminnya nonaktif.
        // Jurusan milik akun yang sedang diedit juga tetap dimasukkan.
        $jurusanKosong = $this->jurusanTersedia($akun);

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
                'exists:jurusans,id_jurusan',
                'required_if:role,admin_jurusan',
            ],
        ]);


        $jurusanLama = $akun->jurusanDipegang;
        $jurusanBaru = null;


        // =====================================================
        // JIKA MENJADI / TETAP ADMIN JURUSAN
        // =====================================================

        if ($request->role === 'admin_jurusan') {

            $jurusanBaru = Jurusan::with('user')->findOrFail(
                $request->id_jurusan
            );

            // Diperiksa SEBELUM ada data yang diubah, supaya jika ditolak
            // tidak ada perubahan yang tersimpan setengah-setengah.
            if (!$this->jurusanBisaDipakai($jurusanBaru, $akun->id)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'id_jurusan' =>
                            'Jurusan ini sudah memiliki Admin Jurusan yang aktif.'
                    ]);
            }
        }


        DB::transaction(function () use ($request, $akun, $jurusanLama, $jurusanBaru) {

            // Lepas jurusan lama jika pindah jurusan atau
            // berubah menjadi Admin TEFA.
            if (
                $jurusanLama &&
                (
                    !$jurusanBaru ||
                    (int) $jurusanLama->id_jurusan !== (int) $jurusanBaru->id_jurusan
                )
            ) {
                $jurusanLama->update([
                    'id_user' => null,
                ]);
            }

            // Update data user
            $akun->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'role' => $request->role,
                'status' => $request->status,
            ]);

            // Pasang jurusan baru (jika Admin Jurusan)
            if ($jurusanBaru) {
                $jurusanBaru->update([
                    'id_user' => $akun->id,
                ]);
            }
        });


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


        // Admin Jurusan yang jurusannya sudah diambil alih admin lain
        // tidak boleh langsung diaktifkan: ia tidak lagi memegang jurusan.
        if (
            $request->status === 'aktif' &&
            $akun->role === 'admin_jurusan' &&
            !$akun->jurusanDipegang
        ) {
            return redirect()
                ->back()
                ->withErrors([
                    'status' =>
                        'Akun ini tidak lagi memegang jurusan (sudah dipakai admin lain). '
                        . 'Edit akun dan pilih jurusan terlebih dahulu sebelum mengaktifkannya.'
                ]);
        }


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