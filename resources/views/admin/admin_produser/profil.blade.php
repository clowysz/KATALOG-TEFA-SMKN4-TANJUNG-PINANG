@extends('admin.layouts.app-produser')

@section('title', 'Profil Saya')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profil-produser.css') }}">
@endpush

@section('content')
<div class="profile-page">

    {{-- ================= INFORMASI AKUN ================= --}}
    <div class="tefa-card profile-card">

        <div class="profile-hero">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->nama, 0, 1)) }}
            </div>

            <div class="profile-hero-info">
                <h2 class="profile-name">{{ $user->nama }}</h2>
                <div class="profile-role-badge">Admin Produser</div>
            </div>
        </div>

        <div class="profile-body">
            <div class="profile-section-label">Informasi Akun</div>

            <div class="profile-row">
                <div class="profile-row-label">Nama Lengkap</div>
                <div class="profile-row-value">{{ $user->nama }}</div>
            </div>

            <div class="profile-row">
                <div class="profile-row-label">Email</div>
                <div class="profile-row-value">{{ $user->email }}</div>
            </div>

            <div class="profile-row">
                <div class="profile-row-label">Role</div>
                <div class="profile-row-value">Admin Produser</div>
            </div>

            <div class="profile-row">
                <div class="profile-row-label">Status Akun</div>
                <div class="profile-row-value {{ $user->status === 'aktif' ? 'is-active' : 'is-inactive' }}">
                    {{ $user->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                </div>
            </div>
        </div>

    </div>

    {{-- ================= TANGGUNG JAWAB PRODUK/JASA ================= --}}
    <div class="tefa-card profile-products">

        <div class="profile-products-header">
            <h3 class="profile-products-title">Tanggung Jawab Produk/Jasa</h3>
            <p class="profile-products-desc">
                Produk dan jasa yang berada di bawah pengelolaan Anda.
            </p>
        </div>

        <div class="profile-product-list">
            @forelse($penugasan as $item)
                @php
                    $produk = $item->produkJasa;
                    $gambar = $produk?->gambars?->first();
                @endphp

                @if($produk)
                    <div class="profile-product-item">

                        <div class="profile-product-main">
                            @if($gambar)
                                <img src="{{ asset('storage/'.$gambar->path_gambar) }}"
                                     alt="{{ $produk->nama_produk_jasa }}"
                                     class="profile-product-thumb">
                            @else
                                <div class="profile-product-thumb profile-product-thumb-empty">
                                    <i class="ph ph-image"></i>
                                </div>
                            @endif

                            <div>
                                <div class="profile-product-name">
                                    {{ $produk->nama_produk_jasa }}
                                </div>

                                <div class="profile-product-meta">
                                    <span class="{{ $produk->jenis === 'produk' ? 'badge-tipe-produk-new' : 'badge-tipe-jasa-new' }}">
                                        {{ ucfirst($produk->jenis) }}
                                    </span>

                                    <span class="profile-product-jurusan">
                                        {{ $produk->jurusan->nama_jurusan ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="profile-product-side">
                            <div class="profile-product-price">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </div>

                            <div class="profile-product-count">
                                {{ $produk->pesanans->count() }} pesanan
                            </div>
                        </div>

                    </div>
                @endif
            @empty
                <div class="prod-empty">
                    <i class="ph ph-package prod-empty-icon"></i>
                    <p class="prod-empty-text">
                        Belum ada produk atau jasa yang ditugaskan kepada Anda.
                    </p>
                </div>
            @endforelse
        </div>

    </div>

</div>
@endsection