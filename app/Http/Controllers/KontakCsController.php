<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Pengaturan nomor WhatsApp Customer Service (admin Tefa).
 */
class KontakCsController extends Controller
{
    public function index()
    {
        // Tampilan: 0896-5362-8650
        $nomorCs = Pengaturan::formatNomor(Pengaturan::nomorCs());

        // Link untuk menguji nomor yang sedang tersimpan
        $urlWhatsapp = Pengaturan::urlWhatsapp();

        return view(
            'admin.admin_tefa.customer-service',
            compact('nomorCs', 'urlWhatsapp')
        );
    }

    public function update(Request $request)
    {
        $nomor = Pengaturan::normalisasiNomor($request->input('nomor_cs'));

        Validator::make(
            ['nomor_cs' => $nomor],
            ['nomor_cs' => ['required', 'regex:' . Pengaturan::NOMOR_REGEX]],
            [
                'nomor_cs.required' => 'Nomor Customer Service wajib diisi.',
                'nomor_cs.regex' => Pengaturan::PESAN_NOMOR_TIDAK_VALID,
            ]
        )->validate();

        Pengaturan::simpan(Pengaturan::KUNCI_NOMOR_CS, $nomor);

        return redirect()
            ->route('tefa.cs.index')
            ->with('sukses', 'Nomor Customer Service berhasil diperbarui.');
    }
}