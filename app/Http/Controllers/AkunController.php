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

    private function jurusanBisaDipakai(Jurusan $jurusan, ?int $akunId = null): bool
    {

        if (!$jurusan->id_user) {
            return true;
        }

        if ($akunId && (int) $jurusan->id_user === $akunId) {
            return true;
        }

        $pemegang = $jurusan->user;

        return !$pemegang || $pemegang->status === 'tidak_aktif';
    }

    public function index()
    {

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

    public function create()
    {

        $jurusanKosong = $this->jurusanTersedia();

        return view(
            'admin.admin_tefa.akun.create',
            compact('jurusanKosong')
        );
    }

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

        if ($request->role === 'admin_jurusan') {

            $jurusan = Jurusan::with('user')->findOrFail(
                $request->id_jurusan
            );

            if (!$this->jurusanBisaDipakai($jurusan)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'id_jurusan' =>
                            'Jurusan ini sudah memiliki Admin Jurusan yang aktif.'
                    ]);
            }

            $adminLama = $jurusan->user;

            DB::transaction(function () use ($request, $jurusan) {

                $akun = User::create([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'admin_jurusan',
                    'status' => $request->status,
                ]);

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

    public function edit($id)
    {
        $akun = User::whereIn('role', [
            'admin_tefa',
            'admin_jurusan',
        ])
        ->with('jurusanDipegang')
        ->findOrFail($id);

        $jurusanKosong = $this->jurusanTersedia($akun);

        return view(
            'admin.admin_tefa.akun.edit',
            compact(
                'akun',
                'jurusanKosong'
            )
        );
    }

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

        if ($request->role === 'admin_jurusan') {

            $jurusanBaru = Jurusan::with('user')->findOrFail(
                $request->id_jurusan
            );

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

            $akun->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'role' => $request->role,
                'status' => $request->status,
            ]);

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