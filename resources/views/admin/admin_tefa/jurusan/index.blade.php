    @extends('admin.layouts.app')

    @section('title', 'Jurusan')

    @section('content')

    <div class="jurusan-page">
        <div class="jurusan-container">

            <h1 class="page-title">Jurusan</h1>

            <div class="jurusan-grid">

                {{-- RPL --}}
                <div class="jurusan-card rpl">
                    <h2>Rekayasa Perangkat Lunak</h2>

                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Produk</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">5</span>
                            <span class="stat-label">Jasa</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">12</span>
                            <span class="stat-label">Portofolio</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">2</span>
                            <span class="stat-label">Pesanan</span>
                        </div>
                    </div>
                </div>

                {{-- TKJ --}}
                <div class="jurusan-card tkj">
                    <h2>Teknik Komputer dan Jaringan</h2>

                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">6</span>
                            <span class="stat-label">Produk</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">5</span>
                            <span class="stat-label">Jasa</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">10</span>
                            <span class="stat-label">Portofolio</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">1</span>
                            <span class="stat-label">Pesanan</span>
                        </div>
                    </div>
                </div>

                {{-- DKV --}}
                <div class="jurusan-card dkv">
                    <h2>Desain Komunikasi Visual</h2>

                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Produk</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">5</span>
                            <span class="stat-label">Jasa</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">15</span>
                            <span class="stat-label">Portofolio</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">2</span>
                            <span class="stat-label">Pesanan</span>
                        </div>
                    </div>
                </div>

                {{-- ANIMASI --}}
                <div class="jurusan-card animasi">
                    <h2>Animasi</h2>

                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">4</span>
                            <span class="stat-label">Produk</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">4</span>
                            <span class="stat-label">Jasa</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">9</span>
                            <span class="stat-label">Portofolio</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">1</span>
                            <span class="stat-label">Pesanan</span>
                        </div>
                    </div>
                </div>

                {{-- GIM --}}
                <div class="jurusan-card gim">
                    <h2>GIM</h2>

                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">4</span>
                            <span class="stat-label">Produk</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">4</span>
                            <span class="stat-label">Jasa</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Portofolio</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">1</span>
                            <span class="stat-label">Pesanan</span>
                        </div>
                    </div>
                </div>

                {{-- PSTV --}}
                <div class="jurusan-card pstv">
                    <h2>Produk Suara Program Televisi</h2>

                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">4</span>
                            <span class="stat-label">Produk</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">4</span>
                            <span class="stat-label">Jasa</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">10</span>
                            <span class="stat-label">Portofolio</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">1</span>
                            <span class="stat-label">Pesanan</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @endsection