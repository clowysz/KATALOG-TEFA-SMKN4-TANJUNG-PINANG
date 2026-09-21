@extends('admin.layouts.app-produser')

@section('title','Profil Saya')

@section('content')
<div style="max-width:800px;margin:0 auto 40px;">

    <!-- INFORMASI AKUN -->
    <div class="tefa-card" style="padding:0;background:white;border-radius:12px;overflow:hidden;margin-bottom:24px;">
        <div style="background:var(--primary);padding:40px 32px;display:flex;align-items:center;gap:24px;">
            <div style="width:80px;height:80px;background:#D8893D;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:36px;font-weight:700;box-shadow:0 4px 10px rgba(0,0,0,.1);">
                {{ strtoupper(substr($user->nama,0,1)) }}
            </div>

            <div>
                <h2 style="font-size:28px;color:white;margin-bottom:8px;font-weight:700;">
                    {{ $user->nama }}
                </h2>

                <div style="background:rgba(255,255,255,.2);color:white;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;display:inline-block;">
                    Admin Produser
                </div>
            </div>
        </div>

        <div style="padding:32px;">
            <div style="font-size:13px;font-weight:700;color:var(--prod-text-sec);text-transform:uppercase;margin-bottom:24px;letter-spacing:.5px;">
                Informasi Akun
            </div>

            <div style="display:flex;justify-content:space-between;padding-bottom:16px;border-bottom:1px solid var(--prod-border);margin-bottom:16px;">
                <div style="color:var(--prod-text-sec);font-size:15px;">Nama Lengkap</div>
                <div style="color:var(--prod-text-main);font-weight:600;font-size:15px;">{{ $user->nama }}</div>
            </div>

            <div style="display:flex;justify-content:space-between;padding-bottom:16px;border-bottom:1px solid var(--prod-border);margin-bottom:16px;">
                <div style="color:var(--prod-text-sec);font-size:15px;">Email</div>
                <div style="color:var(--prod-text-main);font-weight:600;font-size:15px;">{{ $user->email }}</div>
            </div>

            <div style="display:flex;justify-content:space-between;padding-bottom:16px;border-bottom:1px solid var(--prod-border);margin-bottom:16px;">
                <div style="color:var(--prod-text-sec);font-size:15px;">Role</div>
                <div style="color:var(--prod-text-main);font-weight:600;font-size:15px;">Admin Produser</div>
            </div>

            <div style="display:flex;justify-content:space-between;">
                <div style="color:var(--prod-text-sec);font-size:15px;">Status Akun</div>
                <div style="color:{{ $user->status === 'aktif' ? 'var(--prod-success)' : 'var(--prod-error)' }};font-weight:600;font-size:15px;">
                    {{ $user->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                </div>
            </div>
        </div>
    </div>

    <!-- TANGGUNG JAWAB PRODUK/JASA -->
    <div class="tefa-card" style="padding:32px;background:white;border-radius:12px;">
        <div style="margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid var(--prod-border);">
            <h3 style="font-size:18px;color:var(--prod-text-main);margin-bottom:4px;font-weight:700;">
                Tanggung Jawab Produk/Jasa
            </h3>
            <p style="font-size:14px;color:var(--prod-text-sec);">
                Produk dan jasa yang berada di bawah pengelolaan Anda.
            </p>
        </div>

        <div style="display:flex;flex-direction:column;gap:16px;">
            @forelse($penugasan as $item)
                @php
                    $produk = $item->produkJasa;
                    $gambar = $produk?->gambars?->first();
                @endphp

                @if($produk)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:16px;border:1px solid var(--prod-border);border-radius:12px;">

                        <div style="display:flex;align-items:center;gap:16px;">
                            @if($gambar)
                                <img src="{{ asset('storage/'.$gambar->path_gambar) }}"
                                     style="width:56px;height:56px;border-radius:8px;object-fit:cover;border:1px solid var(--prod-border);">
                            @else
                                <div style="width:56px;height:56px;border-radius:8px;background:#F1F5F9;display:flex;align-items:center;justify-content:center;color:var(--prod-text-sec);">
                                    <i class="ph ph-image" style="font-size:24px;"></i>
                                </div>
                            @endif

                            <div>
                                <div style="font-weight:700;color:var(--prod-text-main);font-size:16px;margin-bottom:6px;">
                                    {{ $produk->nama_produk_jasa }}
                                </div>

                                <div style="display:flex;gap:8px;align-items:center;">
                                    <span class="{{ $produk->jenis === 'produk' ? 'badge-tipe-produk-new' : 'badge-tipe-jasa-new' }}">
                                        {{ ucfirst($produk->jenis) }}
                                    </span>

                                    <span style="font-size:12px;color:var(--prod-text-sec);font-weight:500;">
                                        {{ $produk->jurusan->nama_jurusan ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div style="text-align:right;">
                            <div style="font-weight:700;color:var(--primary);font-size:16px;margin-bottom:4px;">
                                Rp {{ number_format($produk->harga,0,',','.') }}
                            </div>

                            <div style="font-size:12px;color:var(--prod-text-sec);">
                                {{ $produk->pesanans->count() }} pesanan
                            </div>
                        </div>

                    </div>
                @endif
            @empty
                <div style="text-align:center;padding:40px 20px;color:var(--prod-text-sec);">
                    <i class="ph ph-package" style="font-size:40px;"></i>
                    <p style="margin:12px 0 0;font-size:14px;">
                        Belum ada produk atau jasa yang ditugaskan kepada Anda.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection