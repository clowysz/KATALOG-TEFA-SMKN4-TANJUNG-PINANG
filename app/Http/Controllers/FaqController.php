<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();

        return view('admin.admin_tefa.faq.index', compact('faqs'));
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

    Faq::create($request->all());

    return redirect()->route('admin.faq.index')
        ->with('success', 'FAQ berhasil ditambahkan');
}

public function update(Request $request, $id)
{
    $request->validate([
        'pertanyaan' => 'required|string',
        'jawaban' => 'required|string',
    ]);

    $faq = Faq::findOrFail($id);
    $faq->update($request->all());

    return redirect()->route('admin.faq.index')
        ->with('success', 'FAQ berhasil diperbarui');
}

public function destroy($id)
{
    $faq = Faq::findOrFail($id);
    $faq->delete();

    return redirect()->route('admin.faq.index')
        ->with('success', 'FAQ berhasil dihapus');
}
}