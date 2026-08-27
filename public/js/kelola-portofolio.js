function openPortoModal(id) { document.getElementById(id).classList.add('active'); }
function closePortoModal(id) { document.getElementById(id).classList.remove('active'); }

function openTambahPortoModal() {
    document.getElementById('formPorto').reset();
    document.getElementById('portoId').value = '';
    document.getElementById('modalPortoTitle').textContent = 'Tambah Portofolio';
    openPortoModal('modalAddPorto');
}

// Override tombol tambah agar menggunakan fungsi clear form
document.querySelector('button[onclick="openPortoModal(\'modalAddPorto\')"]').setAttribute('onclick', 'openTambahPortoModal()');

document.addEventListener("DOMContentLoaded", function() {
    const defaultPorto = [
        { id: 'pt1', title: 'Website Profil Sekolah', desc: 'Pengembangan website interaktif untuk informasi akademik dan pendaftaran siswa baru.', year: '2026', img: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&q=80' },
        { id: 'pt2', title: 'Aplikasi Perpustakaan', desc: 'Sistem manajemen peminjaman buku berbasis web dengan fitur scan barcode.', year: '2025', img: 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=400&q=80' },
        { id: 'pt3', title: 'Aplikasi Absensi QR', desc: 'Aplikasi mobile untuk pencatatan kehadiran menggunakan pemindaian kode QR.', year: '2025', img: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&q=80' }
    ];

    if (!localStorage.getItem('rpl_portofolio')) {
        localStorage.setItem('rpl_portofolio', JSON.stringify(defaultPorto));
    }

    let dataPorto = JSON.parse(localStorage.getItem('rpl_portofolio'));
    const container = document.getElementById('portoContainer');
    const searchInput = document.getElementById('searchPorto');
    const toast = document.getElementById('toastPorto');

    function showToast(msg) {
        toast.textContent = msg;
        toast.style.backgroundColor = '#28a745';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    function renderPorto(filterText = '') {
        container.innerHTML = '';
        const filteredData = dataPorto.filter(item => item.title.toLowerCase().includes(filterText.toLowerCase()));
        
        if (filteredData.length === 0) {
            container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px;">
                    <div style="font-size: 56px; margin-bottom: 16px;">📂</div>
                    <h3 style="color: var(--text-dark); margin-bottom: 8px;">Tidak ada portofolio ditemukan.</h3>
                    <p style="color: var(--text-muted);">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            `;
            return;
        }

        filteredData.forEach(item => {
            const card = document.createElement('div');
            card.className = 'portfolio-card';
            card.innerHTML = `
                <img src="${item.img}" alt="${item.title}" class="portfolio-img">
                <div class="portfolio-content">
                    <h4>${item.title}</h4>
                    <p>${item.desc.substring(0, 80)}...</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="portfolio-badge">${item.year}</span>
                    </div>
                    <div class="catalog-actions">
                        <button class="btn-outline btn-edit-porto" data-id="${item.id}">Edit</button>
                        <button class="btn-outline btn-delete-porto" data-id="${item.id}" style="color:#dc3545; border-color:#dc3545;">Hapus</button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

        // Event Edit
        document.querySelectorAll('.btn-edit-porto').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const item = dataPorto.find(d => d.id === id);
                document.getElementById('portoId').value = item.id;
                document.getElementById('portoTitle').value = item.title;
                document.getElementById('portoDesc').value = item.desc;
                document.getElementById('portoYear').value = item.year;
                document.getElementById('portoImg').value = item.img;
                document.getElementById('modalPortoTitle').textContent = 'Edit Portofolio';
                openPortoModal('modalAddPorto');
            });
        });

        // Event Hapus
        document.querySelectorAll('.btn-delete-porto').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('deletePortoId').value = this.getAttribute('data-id');
                openPortoModal('modalDeletePorto');
            });
        });
    }

    renderPorto();

    if (searchInput) searchInput.addEventListener('keyup', function() { renderPorto(this.value); });

    // Simpan Form
    document.getElementById('formPorto').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('portoId').value;
        const isEdit = id !== '';
        
        const newItem = {
            id: isEdit ? id : 'pt' + Date.now(),
            title: document.getElementById('portoTitle').value,
            desc: document.getElementById('portoDesc').value,
            year: document.getElementById('portoYear').value,
            img: document.getElementById('portoImg').value
        };

        if (isEdit) {
            const index = dataPorto.findIndex(d => d.id === id);
            dataPorto[index] = newItem;
            showToast('✓ Portofolio berhasil diperbarui.');
        } else {
            dataPorto.unshift(newItem);
            showToast('✓ Portofolio berhasil ditambahkan.');
        }

        localStorage.setItem('rpl_portofolio', JSON.stringify(dataPorto));
        renderPorto(searchInput.value);
        closePortoModal('modalAddPorto');
    });

    // Hapus
    document.getElementById('btnConfirmDeletePorto').addEventListener('click', function() {
        const id = document.getElementById('deletePortoId').value;
        dataPorto = dataPorto.filter(d => d.id !== id);
        localStorage.setItem('rpl_portofolio', JSON.stringify(dataPorto));
        renderPorto(searchInput.value);
        closePortoModal('modalDeletePorto');
        showToast('✓ Portofolio berhasil dihapus.');
    });
});