document.addEventListener("DOMContentLoaded", function() {
    // 1. Ambil data layanan dari localStorage (Produk & Jasa)
    const dataProduk = JSON.parse(localStorage.getItem('rpl_produk')) || [];
    const dataJasa = JSON.parse(localStorage.getItem('rpl_jasa')) || [];
    const semuaLayanan = [...dataProduk, ...dataJasa];

    // 2. Data Akun Default (SESUAI CONTOH FIGMA KAMU)
    const defaultAkun = [
        { id: 'ak1', nama: 'Budi Santoso', email: 'budi.santoso@smkn4.sch.id', role: 'Admin Produser', layanan: ['Aplikasi Kasir', 'Pembuatan Website'], status: 'Aktif', password: 'password123' },
        { id: 'ak2', nama: 'Siti Rahayu', email: 'siti.rahayu@smkn4.sch.id', role: 'Admin Produser', layanan: ['Sistem Informasi Sekolah', 'Pemeliharaan Website'], status: 'Aktif', password: 'password123' },
        { id: 'ak3', nama: 'Ahmad Fauzi', email: 'ahmad.fauzi@smkn4.sch.id', role: 'Admin Produser', layanan: ['Aplikasi Inventori', 'Hosting & Domain'], status: 'Tidak Aktif', password: 'password123' }
    ];

    let dataAkun = JSON.parse(localStorage.getItem('rpl_akun'));
    
    // Paksa perbarui data jika sebelumnya nyangkut di data lama yang salah
    if (!dataAkun || dataAkun.length < 3 || dataAkun[1].nama !== 'Siti Rahayu') {
        dataAkun = defaultAkun;
        localStorage.setItem('rpl_akun', JSON.stringify(dataAkun));
    }

    // ================= HALAMAN TAMBAH AKUN =================
    const formTambah = document.getElementById('formTambahAkunJurusan');
    if (formTambah) {
        const checkboxContainer = document.getElementById('checkboxContainer');
        
        // Render Checkbox dari data Katalog
        if (checkboxContainer) {
            checkboxContainer.innerHTML = '';
            if (semuaLayanan.length === 0) {
                checkboxContainer.innerHTML = '<div style="color:#dc3545;">Belum ada produk/jasa. Tambahkan di katalog terlebih dahulu.</div>';
            } else {
                semuaLayanan.forEach((item, index) => {
                    const badgeClass = item.type === 'Produk' ? 'badge-tipe-produk' : 'badge-tipe-jasa';
                    checkboxContainer.innerHTML += `
                        <div>
                            <input type="checkbox" id="layanan_${index}" name="layananAkun" value="${item.name}" class="chip-input">
                            <label for="layanan_${index}" class="chip-label">
                                <span class="${badgeClass}">${item.type}</span> ${item.name}
                            </label>
                        </div>
                    `;
                });
            }
        }

        // Submit Form Tambah
        formTambah.addEventListener('submit', function(e) {
            e.preventDefault();
            const checkedLayanan = Array.from(document.querySelectorAll('input[name="layananAkun"]:checked')).map(cb => cb.value);
            const errorLayanan = document.getElementById('errorLayanan');
            
            if (checkedLayanan.length === 0) {
                errorLayanan.style.display = 'block';
                return;
            }
            errorLayanan.style.display = 'none';

            const newAkun = {
                id: 'ak' + Date.now(),
                nama: document.getElementById('nama').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                role: 'Admin Produser',
                layanan: checkedLayanan,
                status: 'Aktif'
            };

            dataAkun.unshift(newAkun);
            localStorage.setItem('rpl_akun', JSON.stringify(dataAkun));

            const toast = document.getElementById('toastAkun');
            toast.classList.add('show');
            setTimeout(() => { window.location.href = '/jurusan-admin/akun'; }, 1500);
        });
    }

    // ================= HALAMAN DAFTAR AKUN =================
    const tableBody = document.getElementById('akunTableBody');
    if (tableBody) {
        const filterLayanan = document.getElementById('filterLayanan');
        
        // Isi dropdown filter layanan
        if (filterLayanan && filterLayanan.options.length <= 1) {
            semuaLayanan.forEach(item => {
                const option = document.createElement('option');
                option.value = item.name;
                option.textContent = item.name;
                filterLayanan.appendChild(option);
            });
        }

        const searchInput = document.getElementById('searchAkun');
        const filterStatus = document.getElementById('filterStatus');
        const emptyAkun = document.getElementById('emptyAkun');

        function renderTable() {
            tableBody.innerHTML = '';
            const searchVal = searchInput ? searchInput.value.toLowerCase() : '';
            const statusVal = filterStatus ? filterStatus.value : 'Semua';
            const layananVal = filterLayanan ? filterLayanan.value : 'Semua';

            const filteredData = dataAkun.filter(akun => {
                const matchSearch = akun.nama.toLowerCase().includes(searchVal) || akun.email.toLowerCase().includes(searchVal);
                const matchStatus = statusVal === 'Semua' || akun.status === statusVal;
                const matchLayanan = layananVal === 'Semua' || akun.layanan.includes(layananVal);
                return matchSearch && matchStatus && matchLayanan;
            });

            if (filteredData.length === 0) {
                if(emptyAkun) emptyAkun.style.display = 'block';
                tableBody.parentElement.style.display = 'none';
            } else {
                if(emptyAkun) emptyAkun.style.display = 'none';
                tableBody.parentElement.style.display = 'table';
                
                filteredData.forEach(akun => {
                    const badgeClass = akun.status === 'Aktif' ? 'badge-active' : 'badge-grey';
                    
                    // Render Chip Tanggung Jawab
                    const layananChips = akun.layanan.map(l => {
                        const layananObj = semuaLayanan.find(s => s.name === l);
                        const type = layananObj ? layananObj.type : 'Layanan';
                        const typeClass = type === 'Produk' ? 'badge-tipe-produk' : 'badge-tipe-jasa';
                        return `<div class="chip-label" style="padding: 4px 12px; border-radius: 20px; font-size: 12px; cursor: default; margin-bottom: 4px; display: inline-flex; border-color:#eee; background:#fff;"><span class="${typeClass}" style="margin-right: 6px; padding: 2px 6px;">${type}</span> ${l}</div>`;
                    }).join('');

                    tableBody.innerHTML += `
                        <tr>
                            <td><strong style="color:var(--text-dark);">${akun.nama}</strong></td>
                            <td style="color:var(--text-muted);">${akun.email}</td>
                            <td><span class="role-badge" style="background: #f0f7ff; color: var(--primary); padding: 6px 12px; border-radius: 20px; font-size: 12px; display: inline-block; text-align: center; font-weight: 500;">Admin<br>Produk/Jasa</span></td>
                            <td><div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">${layananChips}</div></td>
                            <td><span class="badge ${badgeClass}">${akun.status}</span></td>
                            <td><a href="/jurusan-admin/akun/detail?id=${akun.id}" class="btn-outline" style="padding: 8px 16px;">Lihat Detail</a></td>
                        </tr>
                    `;
                });
            }
        }

        renderTable();
        
        // Event Listeners untuk Filter & Search
        if (searchInput) searchInput.addEventListener('keyup', renderTable);
        if (filterStatus) filterStatus.addEventListener('change', renderTable);
        if (filterLayanan) filterLayanan.addEventListener('change', renderTable);
    }
});