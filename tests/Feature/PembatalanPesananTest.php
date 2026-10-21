<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PembatalanPesananTest extends TestCase
{
    use RefreshDatabase;

    private function buatUser(string $role, string $email): User
    {
        return User::create([
            'nama' => 'User Testing',
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => $role,
        ]);
    }

    private function buatPesanan(string $status, int $idUser): int
    {
        $idJurusan = DB::table('jurusans')->insertGetId([
            'nama_jurusan' => 'RPL Testing',
            'kode_jurusan' => 'RPLTEST',
            'slug' => 'rpl-testing',
            'created_at' => now(),
            'updated_at' => now(),
        ], 'id_jurusan');

        $idProduk = DB::table('produk_jasa')->insertGetId([
            'id_jurusan' => $idJurusan,
            'nama_produk_jasa' => 'Produk Testing',
            'jenis' => 'produk',
            'deskripsi' => 'Produk untuk pengujian',
            'harga' => 10000,
            'created_at' => now(),
            'updated_at' => now(),
        ], 'id_produk_jasa');

        return DB::table('pesanan')->insertGetId([
            'id_user' => $idUser,
            'id_produk_jasa' => $idProduk,
            'tanggal_pesan' => now(),
            'jumlah' => 1,
            'total_harga' => 10000,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ], 'id_pesanan');
    }

    public function test_pembeli_dapat_membatalkan_pesanan_yang_menunggu_konfirmasi(): void
    {
        $pembeli = $this->buatUser(
            'pembeli',
            'pembeli1@example.test'
        );

        $idPesanan = $this->buatPesanan(
            'menunggu konfirmasi',
            $pembeli->id
        );

        $response = $this->actingAs($pembeli)->post(
            "/riwayat-pesanan/{$idPesanan}/batalkan",
            ['alasan' => 'Ingin membatalkan pesanan']
        );

        $response->assertRedirect('/riwayat-pesanan');

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $idPesanan,
            'status' => 'dibatalkan',
        ]);

        $this->assertDatabaseHas('riwayat_status_pesanan', [
            'id_pesanan' => $idPesanan,
            'status' => 'dibatalkan',
        ]);
    }

    public function test_pembatalan_pesanan_terkonfirmasi_menunggu_admin(): void
    {
        $pembeli = $this->buatUser(
            'pembeli',
            'pembeli2@example.test'
        );

        $idPesanan = $this->buatPesanan(
            'konfirmasi',
            $pembeli->id
        );

        $response = $this->actingAs($pembeli)->post(
            "/riwayat-pesanan/{$idPesanan}/batalkan",
            ['alasan' => 'Ada perubahan rencana']
        );

        $response->assertRedirect('/riwayat-pesanan');

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $idPesanan,
            'status' => 'konfirmasi',
        ]);

        $this->assertDatabaseHas('permintaan_pembatalan', [
            'id_pesanan' => $idPesanan,
            'status_permintaan' => 'menunggu',
        ]);
    }

    public function test_admin_dapat_menyetujui_pembatalan(): void
    {
        $pembeli = $this->buatUser(
            'pembeli',
            'pembeli3@example.test'
        );

        $admin = $this->buatUser(
            'admin_tefa',
            'admin1@example.test'
        );

        $idPesanan = $this->buatPesanan(
            'konfirmasi',
            $pembeli->id
        );

        $idPermintaan = DB::table('permintaan_pembatalan')
            ->insertGetId([
                'id_pesanan' => $idPesanan,
                'alasan' => 'Tidak jadi membeli',
                'status_permintaan' => 'menunggu',
                'created_at' => now(),
                'updated_at' => now(),
            ], 'id_permintaan');

        $response = $this->actingAs($admin)->post(
            "/pesanan/permintaan-pembatalan/{$idPermintaan}/setujui"
        );

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $idPesanan,
            'status' => 'dibatalkan',
        ]);

        $this->assertDatabaseHas('permintaan_pembatalan', [
            'id_permintaan' => $idPermintaan,
            'status_permintaan' => 'disetujui',
        ]);

        $this->assertDatabaseHas('riwayat_status_pesanan', [
            'id_pesanan' => $idPesanan,
            'status' => 'dibatalkan',
        ]);
    }

    public function test_admin_dapat_menolak_pembatalan(): void
    {
        $pembeli = $this->buatUser(
            'pembeli',
            'pembeli4@example.test'
        );

        $admin = $this->buatUser(
            'admin_tefa',
            'admin2@example.test'
        );

        $idPesanan = $this->buatPesanan(
            'konfirmasi',
            $pembeli->id
        );

        $idPermintaan = DB::table('permintaan_pembatalan')
            ->insertGetId([
                'id_pesanan' => $idPesanan,
                'alasan' => 'Ingin membatalkan',
                'status_permintaan' => 'menunggu',
                'created_at' => now(),
                'updated_at' => now(),
            ], 'id_permintaan');

        $response = $this->actingAs($admin)->post(
            "/pesanan/permintaan-pembatalan/{$idPermintaan}/tolak",
            ['catatan_admin' => 'Pesanan tetap dilanjutkan']
        );

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $idPesanan,
            'status' => 'konfirmasi',
        ]);

        $this->assertDatabaseHas('permintaan_pembatalan', [
            'id_permintaan' => $idPermintaan,
            'status_permintaan' => 'ditolak',
        ]);
    }

    public function test_pembeli_tidak_dapat_membatalkan_pesanan_milik_orang_lain(): void
    {
        $pemilik = $this->buatUser(
            'pembeli',
            'pemilik@example.test'
        );

        $pembeliLain = $this->buatUser(
            'pembeli',
            'pembelilain@example.test'
        );

        $idPesanan = $this->buatPesanan(
            'menunggu konfirmasi',
            $pemilik->id
        );

        $response = $this->actingAs($pembeliLain)->post(
            "/riwayat-pesanan/{$idPesanan}/batalkan",
            ['alasan' => 'Mencoba membatalkan pesanan orang lain']
        );

        $response->assertNotFound();

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $idPesanan,
            'status' => 'menunggu konfirmasi',
        ]);
    }
}
