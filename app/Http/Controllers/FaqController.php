<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest('id_faq')->get();

        return view(
            'admin.admin_tefa.faq.index',
            compact('faqs')
        );
    }

    public function create()
    {
        return view('admin.admin_tefa.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        Faq::create([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
            'id_user' => Auth::id(),
        ]);

        return redirect()
            ->route('tefa.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);

        return view(
            'admin.admin_tefa.faq.edit',
            compact('faq')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        $faq = Faq::findOrFail($id);

        $faq->update([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        return redirect()
            ->route('tefa.faq.index')
            ->with('success', 'FAQ berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);

        $faq->delete();

        return redirect()
            ->route('tefa.faq.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }
}