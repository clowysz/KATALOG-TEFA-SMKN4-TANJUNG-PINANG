<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $pesanans = Pesanan::latest()->get();

        return view('pesanan.index', compact('pesanans'));
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'no_pesanan' => 'required',
            'nama_pembeli' => 'required',
            'produk_jasa' => 'required',
            'jurusan' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
        ]);

        Pesanan::create([
            'no_pesanan' => $request->no_pesanan,
            'nama_pembeli' => $request->nama_pembeli,
            'produk_jasa' => $request->produk_jasa,
            'jurusan' => $request->jurusan,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan!');
    }

    // Update status pesanan
    public function updateStatus(Request $request, $id) 
    { 
    
    $request->validate([ 'status' => 'required|in:menunggu konfirmasi,konfirmasi,diproses,selesai,dibatalkan', ]); 
    
    $pesanan = Pesanan::findOrFail($id); 
    
    $pesanan->status = $request->status; 
    
    $pesanan->save(); 
    
    return redirect() 
    ->back() ->with('success', 'Status pesanan berhasil diperbarui!'); } 

    // Menghapus pesanan
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus!');
    }
}
