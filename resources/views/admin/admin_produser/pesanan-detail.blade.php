@extends('admin.layouts.app-produser')
@section('title','Detail Pesanan')
@section('content')
@php
$tahapanList=$pesanan->tahapanPengerjaan->sortBy('urutan')->values();
$bolehKelola=$pesanan->status==='diproses';
@endphp
<div class="container-fluid py-4" id="produserOrderPage">
<div class="d-flex justify-content-between align-items-center mb-4">
<div><h3 class="fw-bold mb-1">Detail Pesanan</h3><p class="text-muted mb-0">Kelola pengerjaan pesanan dan tahapan pekerjaan.</p></div>
<a href="{{ route('admin.produser.pesanan') }}" class="btn btn-outline-secondary"><i class="ph ph-arrow-left me-1"></i>Kembali</a>
</div>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="ph ph-check-circle me-1"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
<div class="card border-0 shadow-sm rounded-4 mb-4">
<div class="card-body p-4">
<div class="row align-items-center">
<div class="col-lg-8">
<div class="d-flex align-items-center gap-2 mb-2"><span class="badge bg-light text-dark border">#{{ $pesanan->id_pesanan }}</span><span class="badge bg-primary">{{ ucfirst($pesanan->status) }}</span></div>
<h2 class="fw-bold mb-2">{{ $pesanan->produkJasa->nama_produk_jasa ?? 'Produk/Jasa' }}</h2>
<div class="text-muted"><span class="me-3"><i class="ph ph-tag me-1"></i>{{ ucfirst($pesanan->produkJasa->jenis ?? '-') }}</span>@if($pesanan->produkJasa?->jurusan)<span><i class="ph ph-buildings me-1"></i>{{ $pesanan->produkJasa->jurusan->nama_jurusan }}</span>@endif</div>
</div>
<div class="col-lg-4 text-lg-end mt-3 mt-lg-0"><div class="small text-muted mb-1">Total Pesanan</div><div class="fs-3 fw-bold">Rp {{ number_format($pesanan->total_harga,0,',','.') }}</div><div class="small text-muted">{{ $pesanan->jumlah }} item</div></div>
</div>
</div>
</div>
<div class="row g-4 mb-4">
<div class="col-lg-8">
<div class="card border-0 shadow-sm rounded-4 h-100">
<div class="card-body p-4">
<h5 class="fw-bold mb-4"><i class="ph ph-info me-2"></i>Informasi Pesanan</h5>
<div class="row g-4">
<div class="col-md-6"><div class="small text-muted mb-1">Tanggal Pesanan</div><div class="fw-semibold">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }}</div></div>
<div class="col-md-6"><div class="small text-muted mb-1">Harga Satuan</div><div class="fw-semibold">Rp {{ number_format($pesanan->produkJasa->harga ?? 0,0,',','.') }}</div></div>
<div class="col-md-6"><div class="small text-muted mb-1">Jumlah</div><div class="fw-semibold">{{ $pesanan->jumlah }} item</div></div>
<div class="col-md-6"><div class="small text-muted mb-1">Total Harga</div><div class="fw-semibold">Rp {{ number_format($pesanan->total_harga,0,',','.') }}</div></div>
</div>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="card border-0 shadow-sm rounded-4 h-100">
<div class="card-body p-4">
<h5 class="fw-bold mb-3"><i class="ph ph-note me-2"></i>Catatan Pembeli</h5>
@if($pesanan->catatan)<div class="text-muted" style="white-space:pre-line;">{{ $pesanan->catatan }}</div>@else<div class="text-muted">Tidak ada catatan dari pembeli.</div>@endif
</div>
</div>
</div>
</div>
<div class="card border-0 shadow-sm rounded-4 mb-4">
<div class="card-body p-4">
<div class="d-flex justify-content-between align-items-center mb-4">
<div><h5 class="fw-bold mb-1"><i class="ph ph-list-numbers me-2"></i>Tahapan Pengerjaan</h5><p class="text-muted mb-0">Atur tahapan pekerjaan pesanan ini.</p></div>
@if($bolehKelola)<button type="button" class="btn btn-primary" onclick="openModalTahapan()"><i class="ph ph-list-plus me-1"></i>Kelola Tahapan</button>@endif
</div>
@if(!$bolehKelola)
<div class="alert alert-light border mb-4"><i class="ph ph-info me-1"></i>Tahapan dan progress dapat dikelola setelah pesanan berstatus <strong>diproses</strong>.</div>
@endif
@if($tahapanList->count())
<div class="row g-3">
@foreach($tahapanList as $index=>$tahapan)
<div class="col-12"><div class="border rounded-4 p-3"><div class="d-flex align-items-start gap-3"><div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;min-width:40px;">{{ $index+1 }}</div><div class="flex-grow-1"><div class="d-flex justify-content-between align-items-start gap-2"><div><h6 class="fw-bold mb-1">{{ $tahapan->nama_tahapan }}</h6><span class="badge bg-light text-dark border">{{ $tahapan->status }}</span></div><div class="fw-bold">{{ $tahapan->persentase_progress }}%</div></div><div class="progress mt-3" style="height:8px;"><div class="progress-bar" role="progressbar" style="width:{{ $tahapan->persentase_progress }}%;"></div></div></div></div></div></div>
@endforeach
</div>
@else
<div class="text-center py-5 text-muted"><i class="ph ph-list-dashes" style="font-size:48px;"></i><p class="mt-3 mb-2 fw-semibold">Belum ada tahapan pengerjaan</p>@if($bolehKelola)<p class="small mb-3">Tambahkan tahapan agar proses pengerjaan dapat dipantau.</p><button type="button" class="btn btn-primary" onclick="openModalTahapan()"><i class="ph ph-plus me-1"></i>Tambah Tahapan</button>@else<p class="small mb-0">Tahapan belum dapat dibuat sebelum pesanan diproses.</p>@endif</div>
@endif
</div>
</div>
@if($bolehKelola)
<div class="card border-0 shadow-sm rounded-4 mb-4">
<div class="card-body p-4">
<div class="mb-4"><h5 class="fw-bold mb-1"><i class="ph ph-chart-line-up me-2"></i>Perbarui Progress</h5><p class="text-muted mb-0">Catat perkembangan pengerjaan pesanan.</p></div>
<form action="{{ route('produser.updateProgress',$pesanan->id_pesanan) }}" method="POST">
@csrf
<div class="row g-4">
<div class="col-md-6"><label class="form-label fw-semibold">Progress Pengerjaan</label><div class="d-flex align-items-center gap-3"><input type="range" class="form-range flex-grow-1" name="persentase_progress" id="updateProgress" min="0" max="100" value="0" oninput="document.getElementById('progressValue').innerText=this.value+'%'"><span id="progressValue" class="fw-bold" style="min-width:45px;">0%</span></div></div>
<div class="col-md-6"><label class="form-label fw-semibold">Keterangan Progress</label><input type="text" name="keterangan_progress" class="form-control" maxlength="255" placeholder="Contoh: Tahap desain sudah selesai." required></div>
<div class="col-12"><button type="submit" class="btn btn-primary"><i class="ph ph-floppy-disk me-1"></i>Simpan Progress</button></div>
</div>
</form>
</div>
</div>
@endif
<div class="card border-0 shadow-sm rounded-4">
<div class="card-body p-4">
<h5 class="fw-bold mb-4"><i class="ph ph-clock-counter-clockwise me-2"></i>Riwayat Progress</h5>
@if($pesanan->progressPengerjaan->count())
<div class="timeline">
@foreach($pesanan->progressPengerjaan->sortByDesc('tanggal_update') as $progress)
<div class="border-start border-2 ps-4 pb-4 position-relative"><span class="position-absolute bg-primary rounded-circle" style="width:12px;height:12px;left:-7px;top:4px;"></span><div class="d-flex justify-content-between align-items-start gap-3"><div><div class="fw-bold">{{ $progress->persentase_progress }}%</div><div class="text-muted">{{ $progress->keterangan_progress }}</div><div class="small text-muted mt-1">Oleh: {{ $progress->pelaksana->nama ?? '-' }}</div></div><div class="small text-muted text-end">{{ \Carbon\Carbon::parse($progress->tanggal_update)->translatedFormat('d M Y') }}<br>{{ \Carbon\Carbon::parse($progress->tanggal_update)->format('H:i') }}</div></div></div>
@endforeach
</div>
@else
<div class="text-center py-4 text-muted"><i class="ph ph-clock" style="font-size:40px;"></i><p class="mb-0 mt-2">Belum ada riwayat progress.</p></div>
@endif
</div>
</div>
</div>
@if($bolehKelola)
<div class="modal fade" id="modalKelolaTahapan" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content border-0 rounded-4">
<div class="modal-header"><div><h5 class="modal-title fw-bold">Kelola Tahapan Pengerjaan</h5><small class="text-muted">Tambah, ubah, hapus, atau atur urutan tahapan.</small></div><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
<div class="d-flex justify-content-end mb-3"><button type="button" class="btn btn-primary" onclick="openFormTambahTahap()"><i class="ph ph-plus me-1"></i>Tambah Tahapan</button></div>
@if($tahapanList->count())
<div class="table-responsive"><table class="table align-middle"><thead><tr><th width="70">No.</th><th>Tahapan</th><th>Status</th><th width="100">Progress</th><th width="180" class="text-end">Aksi</th></tr></thead><tbody>
@foreach($tahapanList as $index=>$tahapan)
<tr>
<td><span class="fw-bold">{{ $index+1 }}</span></td>
<td><div class="fw-semibold">{{ $tahapan->nama_tahapan }}</div></td>
<td><span class="badge bg-light text-dark border">{{ $tahapan->status }}</span></td>
<td>{{ $tahapan->persentase_progress }}%</td>
<td class="text-end"><div class="d-flex justify-content-end gap-1">
@if($index>0)<button type="button" class="btn btn-sm btn-outline-secondary" title="Naik" onclick="reorderTahapan({{ $tahapan->id_tahapan }},'up')"><i class="ph ph-caret-up"></i></button>@endif
@if($index<$tahapanList->count()-1)<button type="button" class="btn btn-sm btn-outline-secondary" title="Turun" onclick="reorderTahapan({{ $tahapan->id_tahapan }},'down')"><i class="ph ph-caret-down"></i></button>@endif
<button type="button" class="btn btn-sm btn-outline-primary" onclick="openEditTahap({{ $tahapan->id_tahapan }},@js($tahapan->nama_tahapan),@js($tahapan->status),{{ $tahapan->persentase_progress }})"><i class="ph ph-pencil-simple"></i></button>
<form action="{{ route('produser.tahapan.destroy',[$pesanan->id_pesanan,$tahapan->id_tahapan]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tahapan ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="ph ph-trash"></i></button></form>
</div></td>
</tr>
@endforeach
</tbody></table></div>
@else
<div class="text-center py-4 text-muted"><p class="mb-0">Belum ada tahapan.</p></div>
@endif
</div>
</div>
</div>
</div>
<div class="modal fade" id="modalFormTahap" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 rounded-4">
<div class="modal-header"><h5 class="modal-title fw-bold" id="modalFormTahapTitle">Tambah Tahapan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<form id="formSimpanTahap" method="POST" action="{{ route('produser.tahapan.store',$pesanan->id_pesanan) }}">@csrf<div id="methodContainer"></div>
<div class="modal-body">
<div class="mb-3"><label class="form-label fw-semibold">Nama Tahapan</label><input type="text" name="nama_tahapan" id="inputNamaTahap" class="form-control" maxlength="255" placeholder="Contoh: Analisis Kebutuhan" required></div>
<div class="mb-3"><label class="form-label fw-semibold">Status</label><select name="status" id="inputStatusTahap" class="form-select" required><option value="Belum Dimulai">Belum Dimulai</option><option value="Sedang Dikerjakan">Sedang Dikerjakan</option><option value="Dalam Revisi">Dalam Revisi</option><option value="Selesai">Selesai</option></select></div>
<div class="mb-3"><label class="form-label fw-semibold">Progress</label><div class="d-flex align-items-center gap-3"><input type="range" name="persentase_progress" id="inputProgressTahap" class="form-range" min="0" max="100" value="0" oninput="document.getElementById('tahapProgressValue').innerText=this.value+'%'"><span id="tahapProgressValue" class="fw-bold" style="min-width:45px;">0%</span></div></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary"><i class="ph ph-floppy-disk me-1"></i>Simpan</button></div>
</form>
</div>
</div>
</div>
<form id="formReorderTahapan" action="{{ route('produser.tahapan.reorder',$pesanan->id_pesanan) }}" method="POST" style="display:none;">@csrf<div id="reorderInputs"></div></form>
@endif
@endsection
@push('scripts')
<script>
const modalKelolaElement=document.getElementById('modalKelolaTahapan');
const modalFormElement=document.getElementById('modalFormTahap');
const modalKelolaTahapan=modalKelolaElement&&typeof bootstrap!=='undefined'?new bootstrap.Modal(modalKelolaElement):null;
const modalFormTahap=modalFormElement&&typeof bootstrap!=='undefined'?new bootstrap.Modal(modalFormElement):null;
function openModalTahapan(){if(modalKelolaTahapan)modalKelolaTahapan.show();}
function openFormTambahTahap(){document.getElementById('modalFormTahapTitle').innerText='Tambah Tahapan';document.getElementById('formSimpanTahap').action="{{ route('produser.tahapan.store',$pesanan->id_pesanan) }}";document.getElementById('methodContainer').innerHTML='';document.getElementById('inputNamaTahap').value='';document.getElementById('inputStatusTahap').value='Belum Dimulai';document.getElementById('inputProgressTahap').value=0;document.getElementById('tahapProgressValue').innerText='0%';if(modalKelolaTahapan)modalKelolaTahapan.hide();setTimeout(()=>{if(modalFormTahap)modalFormTahap.show();},250);}
function openEditTahap(idTahapan,namaTahapan,statusTahapan,progressTahapan){document.getElementById('modalFormTahapTitle').innerText='Edit Tahapan';document.getElementById('formSimpanTahap').action="{{ url('/produser/pesanan/'.$pesanan->id_pesanan.'/tahapan') }}/"+idTahapan;document.getElementById('methodContainer').innerHTML='<input type="hidden" name="_method" value="PUT">';document.getElementById('inputNamaTahap').value=namaTahapan;document.getElementById('inputStatusTahap').value=statusTahapan;document.getElementById('inputProgressTahap').value=progressTahapan;document.getElementById('tahapProgressValue').innerText=progressTahapan+'%';if(modalKelolaTahapan)modalKelolaTahapan.hide();setTimeout(()=>{if(modalFormTahap)modalFormTahap.show();},250);}
function reorderTahapan(idTahapan,arah){const rows=Array.from(document.querySelectorAll('#modalKelolaTahapan tbody tr'));const ids=rows.map(row=>{const button=row.querySelector('button[onclick^="openEditTahap"]');if(!button)return null;const match=button.getAttribute('onclick').match(/openEditTahap\(\s*(\d+)/);return match?parseInt(match[1]):null;}).filter(Boolean);const index=ids.indexOf(idTahapan);if(index===-1)return;if(arah==='up'&&index>0)[ids[index-1],ids[index]]=[ids[index],ids[index-1]];if(arah==='down'&&index<ids.length-1)[ids[index],ids[index+1]]=[ids[index+1],ids[index]];const container=document.getElementById('reorderInputs');container.innerHTML='';ids.forEach(id=>{const input=document.createElement('input');input.type='hidden';input.name='urutan[]';input.value=id;container.appendChild(input);});document.getElementById('formReorderTahapan').submit();}
</script>
@endpush