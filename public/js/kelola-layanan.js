// Fungsi Buka Tutup Modal Biasa
function openLayananModal(id) { document.getElementById(id).classList.add('active'); }
function closeLayananModal(id) { document.getElementById(id).classList.remove('active'); }

// Fungsi Khusus Buka Modal Tambah (Agar form selalu bersih)
function openTambahModal() {
    document.getElementById('formLayanan').reset(); // Kosongkan teks
    document.getElementById('formId').value = '';   // Kosongkan ID
    
    // Deteksi otomatis apakah sedang di halaman produk atau jasa
    const isProduk = document.getElementById('kelolaProdukContainer') !== null;
    document.getElementById('modalFormTitle').textContent = `Tambah ${isProduk ? 'Produk' : 'Jasa'}`;
    
    // Wajibkan upload foto untuk data baru
    const formImg = document.getElementById('formImg');
    if (formImg) {
        formImg.setAttribute('required', 'true');
        formImg.value = '';
    }

    // Kosongkan preview gambar dan array file
    const preview = document.getElementById('imagePreviewContainer');
    if (preview) preview.innerHTML = '';
    if (typeof window.uploadedFiles !== 'undefined') window.uploadedFiles = [];
    
    openLayananModal('modalAdd');
}

// Override tombol tambah bawaan HTML agar pakai fungsi khusus
const btnTambahLayanan = document.querySelector('button[onclick="openLayananModal(\'modalAdd\')"]');
if (btnTambahLayanan) {
    btnTambahLayanan.setAttribute('onclick', 'openTambahModal()');
}

document.addEventListener("DOMContentLoaded", function() {
    const isProduk = document.getElementById('kelolaProdukContainer') !== null;
    const container = document.getElementById(isProduk ? 'kelolaProdukContainer' : 'kelolaJasaContainer');
    const storageKey = isProduk ? 'rpl_produk' : 'rpl_jasa';
    const tipeLayanan = isProduk ? 'Produk' : 'Jasa';

    let dataItems = JSON.parse(localStorage.getItem(storageKey)) || [];

    const searchInput = document.getElementById('searchItem');
    const toast = document.getElementById('toastNotif');

    function showToast(msg) {
        toast.textContent = msg;
        toast.style.backgroundColor = '#28a745';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // --- RENDER CARD & EMPTY STATE ---
    function renderCards(filterText = '') {
        if (!container) return;
        container.innerHTML = '';
        
        const filteredData = dataItems.filter(item => item.name.toLowerCase().includes(filterText.toLowerCase()));
        
        // JIKA PENCARIAN KOSONG (EMPTY STATE)
        if (filteredData.length === 0) {
            container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px;">
                    <div style="font-size: 56px; margin-bottom: 16px;">📫</div>
                    <h3 style="color: var(--text-dark); margin-bottom: 8px;">Tidak ada ${tipeLayanan.toLowerCase()} ditemukan.</h3>
                    <p style="color: var(--text-muted);">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            `;
            return;
        }
        
        // JIKA ADA DATA
        filteredData.forEach(item => {
            const card = document.createElement('div');
            card.className = 'catalog-card';
            card.innerHTML = `
                <img src="${item.img}" alt="${item.name}" class="catalog-img" style="object-fit: cover;">
                <div class="catalog-content">
                    <div class="catalog-title">${item.name}</div>
                    <div class="catalog-desc">${item.desc.substring(0, 60)}...</div>
                    <div class="catalog-meta" style="margin-bottom:0;">
                        <span class="catalog-price">${item.price}</span>
                        <span class="catalog-stats">${item.orders} pesanan</span>
                    </div>
                    <div class="catalog-actions">
                        <button class="btn-outline btn-edit" data-id="${item.id}">Edit</button>
                        <button class="btn-outline btn-delete" data-id="${item.id}" style="color:#dc3545; border-color:#dc3545;">Hapus</button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

        // Pasang Event Edit
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const item = dataItems.find(d => d.id === id);
                
                document.getElementById('formId').value = item.id;
                document.getElementById('formName').value = item.name;
                document.getElementById('formDesc').value = item.desc;
                document.getElementById('formPrice').value = item.price;
                
                // PERBAIKAN: Hilangkan required dan kosongkan input file
                const formImg = document.getElementById('formImg');
                if (formImg) {
                    formImg.removeAttribute('required');
                    formImg.value = ''; 
                }

                // Tampilkan preview gambar lama
                const previewContainer = document.getElementById('imagePreviewContainer');
                if (previewContainer) {
                    previewContainer.innerHTML = `
                        <div style="position: relative; display: inline-block;">
                            <img src="${item.img}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #CBD5E1;">
                            <div style="font-size: 11px; text-align: center; margin-top: 4px; color: #64748b;">Gambar Lama</div>
                        </div>
                    `;
                }

                if (typeof window.uploadedFiles !== 'undefined') window.uploadedFiles = [];

                document.getElementById('modalFormTitle').textContent = `Edit ${tipeLayanan}`;
                openLayananModal('modalAdd');
            });
        });

        // Pasang Event Hapus
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('deleteId').value = this.getAttribute('data-id');
                openLayananModal('modalDelete');
            });
        });
    }

    renderCards();

    // --- PENCARIAN ---
    if(searchInput) {
        searchInput.addEventListener('keyup', function() {
            renderCards(this.value);
        });
    }

    // --- SIMPAN FORM (TAMBAH / EDIT) ---
    const form = document.getElementById('formLayanan');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('formId').value;
            const isEdit = id !== '';
            
            // Logika gambar prototype LocalStorage
            let finalImage = '';
            // Jika ada file foto baru yang diunggah
            if (typeof window.uploadedFiles !== 'undefined' && window.uploadedFiles.length > 0) {
                finalImage = URL.createObjectURL(window.uploadedFiles[0]);
            } else if (isEdit) {
                // Jika edit tapi tidak upload foto baru, pakai foto lama
                const oldItem = dataItems.find(d => d.id === id);
                finalImage = oldItem.img;
            } else {
                // Fallback (seharusnya tidak terjadi)
                finalImage = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&q=80';
            }

            const newItem = {
                id: isEdit ? id : tipeLayanan.charAt(0).toLowerCase() + Date.now(),
                type: tipeLayanan,
                name: document.getElementById('formName').value,
                desc: document.getElementById('formDesc').value,
                price: document.getElementById('formPrice').value,
                img: finalImage,
                orders: isEdit ? dataItems.find(d => d.id === id).orders : 0
            };

            if (isEdit) {
                const index = dataItems.findIndex(d => d.id === id);
                dataItems[index] = newItem;
                showToast(`✓ ${tipeLayanan} berhasil diperbarui.`);
            } else {
                dataItems.unshift(newItem);
                showToast(`✓ ${tipeLayanan} berhasil ditambahkan.`);
            }

            localStorage.setItem(storageKey, JSON.stringify(dataItems));
            renderCards(searchInput.value);
            closeLayananModal('modalAdd');
        });
    }

    // --- HAPUS ---
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    if (btnConfirmDelete) {
        btnConfirmDelete.addEventListener('click', function() {
            const id = document.getElementById('deleteId').value;
            dataItems = dataItems.filter(d => d.id !== id);
            localStorage.setItem(storageKey, JSON.stringify(dataItems));
            
            renderCards(searchInput.value);
            closeLayananModal('modalDelete');
            showToast(`✓ ${tipeLayanan} berhasil dihapus.`);
        });
    }
});