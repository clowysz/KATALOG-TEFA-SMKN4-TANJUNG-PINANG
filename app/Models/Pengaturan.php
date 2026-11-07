<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    public const KUNCI_NOMOR_PDF = 'nomor_pdf';
    public const KUNCI_NOMOR_CS = 'nomor_cs';

    public const NOMOR_DEFAULT = '6289653628650';

    public const NOMOR_REGEX = '/^628\d{8,11}$/';

    public const PESAN_NOMOR_TIDAK_VALID =
        'Nomor tidak valid. Gunakan nomor HP Indonesia, contoh: 0896-5362-8650.';

    protected $table = 'pengaturan';
    protected $primaryKey = 'id_pengaturan';

    protected $fillable = [
        'kunci',
        'nilai',
    ];

    public static function ambil(string $kunci, ?string $default = null): ?string
    {
        return static::where('kunci', $kunci)->value('nilai') ?? $default;
    }

    public static function simpan(string $kunci, ?string $nilai): void
    {
        static::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai]
        );
    }

    public static function nomorPdf(): string
    {
        return static::ambil(self::KUNCI_NOMOR_PDF, self::NOMOR_DEFAULT);
    }

    public static function nomorCs(): string
    {
        return static::ambil(self::KUNCI_NOMOR_CS, self::NOMOR_DEFAULT);
    }

    public static function urlWhatsapp(): string
    {
        return 'https://wa.me/' . static::nomorCs();
    }

    public static function normalisasiNomor($input): string
    {
        $angka = preg_replace('/\D+/', '', is_scalar($input) ? (string) $input : '');

        if (str_starts_with($angka, '62')) {
            return $angka;
        }

        if (str_starts_with($angka, '0')) {
            return '62' . substr($angka, 1);
        }

        if (str_starts_with($angka, '8')) {
            return '62' . $angka;
        }

        return $angka;
    }

    public static function formatNomor(string $nomor): string
    {
        if (!str_starts_with($nomor, '62')) {
            return $nomor;
        }

        $lokal = '0' . substr($nomor, 2);

        return implode('-', array_merge(
            [substr($lokal, 0, 4)],
            str_split(substr($lokal, 4), 4)
        ));
    }
}