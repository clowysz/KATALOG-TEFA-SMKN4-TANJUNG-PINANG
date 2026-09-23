<?php

namespace App\Http\Controllers;

use App\Models\ProdukJasa;
use App\Models\Pesanan;
use App\Models\ProgressPengerjaan;
use App\Models\TahapanPengerjaan;
use App\Models\PenugasanProduser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProduserController extends Controller
{
    // Dashboard Admin Produser
    public function dashboard()
    {
        $user=Auth::user();
        $idProdukSaya=$user->penugasanProduser()->pluck('id_produk_jasa');
        $totalProdukSaya=$idProdukSaya->count();

        $pesananMasuk=Pesanan::with([
            'produkJasa',
            'progressPengerjaan',
            'tahapanPengerjaan',
        ])
        ->whereIn('id_produk_jasa',$idProdukSaya)
        ->where('status','diproses')
        ->latest('tanggal_pesan')
        ->get();

        $totalPesananMasuk=$pesananMasuk->count();

        return view('admin.admin_produser.dashboard',compact(
            'pesananMasuk',
            'totalProdukSaya',
            'totalPesananMasuk'
        ));
    }

    // Daftar pesanan Admin Produser
    public function pesanan()
    {
        $user=Auth::user();
        $idProdukSaya=$user->penugasanProduser()->pluck('id_produk_jasa');

        $pesanans=Pesanan::with([
            'produkJasa',
            'progressPengerjaan',
            'tahapanPengerjaan',
        ])
        ->whereIn('id_produk_jasa',$idProdukSaya)
        ->latest('tanggal_pesan')
        ->get();

        return view('admin.admin_produser.pesanan',compact('pesanans'));
    }

    // Detail pesanan
    public function showPesanan($id_pesanan)
    {
        $user=Auth::user();
        $idProdukSaya=$user->penugasanProduser()->pluck('id_produk_jasa');

        $pesanan=Pesanan::with([
            'produkJasa.jurusan',
            'progressPengerjaan.pelaksana',
            'tahapanPengerjaan',
        ])
        ->where('id_pesanan',$id_pesanan)
        ->whereIn('id_produk_jasa',$idProdukSaya)
        ->firstOrFail();

        return view('admin.admin_produser.pesanan-detail',compact('pesanan'));
    }

    // Update progress pengerjaan
    public function updateProgress(Request $request,$id_pesanan)
    {
        $request->validate([
            'keterangan_progress'=>'required|string|max:255',
            'persentase_progress'=>'required|integer|min:0|max:100',
        ]);

        $user=Auth::user();
        $idProdukSaya=$user->penugasanProduser()->pluck('id_produk_jasa');

        $pesanan=Pesanan::where('id_pesanan',$id_pesanan)
            ->whereIn('id_produk_jasa',$idProdukSaya)
            ->where('status','diproses')
            ->firstOrFail();

        ProgressPengerjaan::create([
            'id_pesanan'=>$pesanan->id_pesanan,
            'persentase_progress'=>$request->persentase_progress,
            'keterangan_progress'=>$request->keterangan_progress,
            'tanggal_update'=>now(),
            'id_user'=>$user->id,
        ]);

        return redirect()->back()->with('success','Progress pengerjaan berhasil diperbarui!');
    }

    // Daftar produk/jasa yang ditugaskan kepada Admin Produser
    public function katalog()
    {
        $user=Auth::user();
        $idProdukSaya=$user->penugasanProduser()->pluck('id_produk_jasa');

        $produkJasas=ProdukJasa::with([
            'jurusan',
            'gambars',
        ])
        ->whereIn('id_produk_jasa',$idProdukSaya)
        ->latest()
        ->get();

        return view('admin.admin_produser.katalog',compact('produkJasas'));
    }

    // Detail produk/jasa
    public function showKatalog($id_produk_jasa)
    {
        $user=Auth::user();
        $idProdukSaya=$user->penugasanProduser()->pluck('id_produk_jasa');

        $produkJasa=ProdukJasa::with([
            'jurusan',
            'gambars',
            'pesanans.progressPengerjaan',
        ])
        ->where('id_produk_jasa',$id_produk_jasa)
        ->whereIn('id_produk_jasa',$idProdukSaya)
        ->firstOrFail();

        return view('admin.admin_produser.katalog-detail',compact('produkJasa'));
    }

    // Profil Admin Produser
    public function profil()
    {
        $user=Auth::user();

        $penugasan=PenugasanProduser::with([
            'produkJasa.gambars',
            'produkJasa.jurusan',
            'produkJasa.pesanans',
        ])
        ->where('id_user_produser',$user->id)
        ->get();

        return view('admin.admin_produser.profil',compact('user','penugasan'));
    }

    // Tambah tahapan pengerjaan
    public function storeTahapan(Request $request,$id_pesanan)
    {
        $request->validate([
            'nama_tahapan'=>'required|string|max:255',
            'status'=>'required|string|max:50',
            'persentase_progress'=>'required|integer|min:0|max:100',
        ]);

        $pesanan=$this->pesananProduser($id_pesanan);

        $urutanTerakhir=TahapanPengerjaan::where(
            'id_pesanan',
            $pesanan->id_pesanan
        )->max('urutan');

        TahapanPengerjaan::create([
            'id_pesanan'=>$pesanan->id_pesanan,
            'nama_tahapan'=>$request->nama_tahapan,
            'urutan'=>($urutanTerakhir ?? 0)+1,
            'status'=>$request->status,
            'persentase_progress'=>$request->persentase_progress,
        ]);

        return redirect()->back()->with('success','Tahapan pengerjaan berhasil ditambahkan!');
    }

    // Edit tahapan pengerjaan
    public function updateTahapan(Request $request,$id_pesanan,$id_tahapan)
    {
        $request->validate([
            'nama_tahapan'=>'required|string|max:255',
            'status'=>'required|string|max:50',
            'persentase_progress'=>'required|integer|min:0|max:100',
        ]);

        $pesanan=$this->pesananProduser($id_pesanan);

        $tahapan=TahapanPengerjaan::where('id',$id_tahapan)
            ->where('id_pesanan',$pesanan->id_pesanan)
            ->firstOrFail();

        $tahapan->update([
            'nama_tahapan'=>$request->nama_tahapan,
            'status'=>$request->status,
            'persentase_progress'=>$request->persentase_progress,
        ]);

        return redirect()->back()->with('success','Tahapan pengerjaan berhasil diperbarui!');
    }

    // Hapus tahapan pengerjaan
    public function destroyTahapan($id_pesanan,$id_tahapan)
    {
        $pesanan=$this->pesananProduser($id_pesanan);

        $tahapan=TahapanPengerjaan::where('id',$id_tahapan)
            ->where('id_pesanan',$pesanan->id_pesanan)
            ->firstOrFail();

        $tahapan->delete();

        return redirect()->back()->with('success','Tahapan pengerjaan berhasil dihapus!');
    }

    // Mengubah urutan tahapan
    public function reorderTahapan(Request $request,$id_pesanan)
    {
        $request->validate([
            'urutan'=>'required|array',
            'urutan.*'=>'integer|exists:tahapan_pengerjaan,id_tahapan',
        ]);

        $pesanan=$this->pesananProduser($id_pesanan);

        foreach($request->urutan as $index=>$idTahapan){
            TahapanPengerjaan::where('id',$idTahapan)
                ->where('id_pesanan',$pesanan->id_pesanan)
                ->update([
                    'urutan'=>$index+1,
                ]);
        }

        return redirect()->back()->with('success','Urutan tahapan berhasil diperbarui!');
    }

    // Memastikan pesanan berasal dari produk/jasa yang ditugaskan kepada produser
    private function pesananProduser($id_pesanan)
    {
        $user=Auth::user();
        $idProdukSaya=$user->penugasanProduser()->pluck('id_produk_jasa');

        return Pesanan::where('id_pesanan',$id_pesanan)
            ->whereIn('id_produk_jasa',$idProdukSaya)
            ->firstOrFail();
    }
}