<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // ======================================================
    // FAQ PEMBELI
    // ======================================================
    public function index()
    {
        $faqs = Faq::all();

        return view('public.faq', compact('faqs'));
    }

    // ======================================================
    // FAQ ADMIN TEFA
    // ======================================================
    public function adminIndex()
    {
        $faqs = Faq::all();

        return view('admin.admin_tefa.faq.index', compact('faqs'));
    }

    // ======================================================
    // TAMBAH FAQ
    // ======================================================
    public function create()
    {
        return view('admin.admin_tefa.faq.create');
    }

    // ======================================================
    // SIMPAN FAQ
    // ======================================================
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        Faq::create($request->all());

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan');
    }

    // ======================================================
    // EDIT FAQ
    // ======================================================
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);

        return view('admin.admin_tefa.faq.edit', compact('faq'));
    }

    // ======================================================
    // UPDATE FAQ
    // ======================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diperbarui');
    }

    // ======================================================
    // HAPUS FAQ
    // ======================================================
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus');
    }
}