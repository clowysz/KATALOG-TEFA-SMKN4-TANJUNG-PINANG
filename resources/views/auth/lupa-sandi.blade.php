@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/login-pembeli.css') }}">
@endpush

@section('content')

<div class="login-page-wrapper">

    {{-- Tombol Kembali --}}
    <div class="login-back-button">
        <a href="{{ route('login') }}">
            <i class="ph ph-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Animasi Gelembung -->
    <div class="bubble" style="width: 80px; height: 80px; top: 15%; left: 15%; animation-duration: 5s;"></div>
    <div class="bubble" style="width: 120px; height: 120px; top: 40%; right: 15%; animation-duration: 7s;"></div>
    <div class="bubble" style="width: 50px; height: 50px; bottom: 25%; left: 25%; animation-duration: 6s;"></div>
    <div class="bubble" style="width: 90px; height: 90px; bottom: 15%; right: 25%; animation-duration: 8s;"></div>

    <div class="login-header-text">
        <h2>Lupa Sandi?</h2>
        <p>Masukkan email yang terdaftar untuk mengatur ulang sandi Anda.</p>
    </div>

    <div class="login-card">

        <div class="login-avatar">
            <i class="ph ph-lock-key-open"></i>
        </div>

        {{-- Pesan berhasil --}}
        @if(session('status'))
            <div class="login-alert login-alert-success">
                {{ session('status') }}

                @if(session('reset_url'))
                    <a href="{{ session('reset_url') }}">
                        Buka Link Reset Sandi
                    </a>
                @endif
            </div>
        @endif

        {{-- Pesan error --}}
        @if($errors->any())
            <div class="login-alert login-alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="login-form-group">
                <label for="email">Email</label>
                <div class="login-input-box">
                    <i class="ph ph-envelope"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="btn-login-submit">
                Kirim Link Reset Sandi
            </button>
        </form>
    </div>

    <p class="login-footer-text">
        Ingat sandi Anda?
        <a href="{{ route('login') }}">Masuk</a>
    </p>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/lupa-sandi-pembeli.js') }}"></script>
@endpush