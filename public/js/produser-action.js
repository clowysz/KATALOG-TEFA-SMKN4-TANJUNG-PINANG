document.addEventListener("DOMContentLoaded", function() {
    
    // ================= DATA DEFAULT DARI FIGMA =================
    const defaultOrders = [
        {
            id: 'ORD-2026-001', productName: 'Website Edukasi', productType: 'Jasa', code: 'PRD-001',
            customer: 'Budi Santoso', price: 'Rp 3.500.000', orderDate: '5 Agustus 2026',
            statusPengerjaan: 'Sedang Dikerjakan', statusPesanan: 'Diproses',
            needTitle: 'Membuat website edukasi untuk lembaga bimbingan belajar.',
            needDesc: 'Website memiliki halaman Beranda, Profil, Program Pembelajaran, Jadwal, Informasi Kontak, dan Formulir Pendaftaran. Website harus responsive dan dapat digunakan melalui perangkat mobile.',
            stages: [
                { id: 1, name: 'Analisis Kebutuhan', status: 'Selesai', progress: 100, date: '10 Agustus 2026', note: 'Diskusi kebutuhan dengan klien selesai. Semua requirement telah didokumentasikan.' },
                { id: 2, name: 'UI/UX Design', status: 'Selesai', progress: 100, date: '12 Agustus 2026', note: 'Wireframe dan mockup telah disetujui oleh klien.' },
                { id: 3, name: 'Development', status: 'Sedang Dikerjakan', progress: 65, date: '-', note: 'Mengembangkan fitur halaman dashboard pengguna dan integrasi database.' },
                { id: 4, name: 'Testing', status: 'Belum Dimulai', progress: 0, date: '-', note: '' },
                { id: 5, name: 'Deployment', status: 'Belum Dimulai', progress: 0, date: '-', note: '' }
            ]
        },
        {
            id: 'ORD-2026-002', productName: 'Website Edukasi', productType: 'Jasa', code: 'PRD-001',
            customer: 'Sari Dewi', price: 'Rp 3.500.000', orderDate: '10 Agustus 2026',
            statusPengerjaan: 'Dalam Revisi', statusPesanan: 'Revisi', needTitle: 'Website Profil Sekolah', needDesc: 'Kebutuhan revisi pada bagian warna tema utama.',
            stages: [{ id: 1, name: 'Development', status: 'Dalam Revisi', progress: 80, date: '15 Agustus 2026', note: 'Revisi warna tema sesuai permintaan.' }]
        }
    ];

    if (!localStorage.getItem('produser_orders') || JSON.parse(localStorage.getItem('produser_orders')).length < 2) {
        localStorage.setItem('produser_orders', JSON.stringify(defaultOrders));
    }
    let dataOrders = JSON.parse(localStorage.getItem('produser_orders'));

    // Fungsi Render Badge Warna Warni
    function getBadge(status) {
        if(status === 'Selesai') return 'badge-soft-green';
        if(status === 'Sedang Dikerjakan' || status === 'Diproses') return 'badge-soft-blue';
        if(status === 'Dalam Revisi' || status === 'Revisi') return 'badge-soft-yellow';
        return 'badge-soft-gray';
    }

   // ================= HALAMAN DASHBOARD & SEMUA PESANAN =================
    const allOrderTable = document.getElementById('allOrderTable');
    const dashboardOrderTable = document.getElementById('dashboardOrderTable');

    function renderTableRows(container, isDashboard = false) {
        if (!container) return;
        container.innerHTML = '';
        const dataToRender = isDashboard ? dataOrders.slice(0, 5) : dataOrders;

        dataToRender.forEach(order => {
            const typeClass = order.productType === 'Produk' ? 'badge-tipe-produk-new' : 'badge-tipe-jasa-new';
            
            let htmlRow = `<tr>`;
            htmlRow += `<td class="order-id-col">${order.id}</td>`;
            htmlRow += `<td><div style="font-weight: 600; color: var(--prod-text-main); margin-bottom: 6px;">${order.productName}</div><span class="${typeClass}">${order.productType}</span></td>`;
            htmlRow += `<td style="font-weight: 500; color: var(--prod-text-main);">${order.customer}</td>`;
            htmlRow += `<td><span class="${getBadge(order.statusPengerjaan)}">${order.statusPengerjaan}</span></td>`;
            htmlRow += `<td><span class="${getBadge(order.statusPesanan)}">${order.statusPesanan}</span></td>`;
            htmlRow += `<td style="text-align: center;"><a href="/produser/pesanan/detail?id=${order.id}" class="btn-light-blue">Lihat Detail</a></td>`;
            htmlRow += `</tr>`;
            container.innerHTML += htmlRow;
        });
    }

    renderTableRows(allOrderTable, false);
    renderTableRows(dashboardOrderTable, true);

    // ================= HALAMAN DETAIL PESANAN INTERAKTIF =================
    const detOrderId = document.getElementById('heroOrderId'); 
    if (detOrderId) {
        const urlParams = new URLSearchParams(window.location.search);
        let orderId = urlParams.get('id') || 'ORD-2026-001'; 
        const orderIndex = dataOrders.findIndex(o => o.id === orderId);
        let order = dataOrders[orderIndex];
        
        
        let activeStageId = order.stages.find(s => s.status !== 'Selesai')?.id || order.stages[order.stages.length - 1].id;


        document.getElementById('heroOrderId').textContent = order.id;
        document.getElementById('heroStatusPesanan').textContent = order.statusPesanan;
        document.getElementById('heroStatusPengerjaan').textContent = order.statusPengerjaan;
        document.getElementById('heroTitle').textContent = order.productName;
        document.getElementById('heroType').textContent = order.productType;
        document.getElementById('heroCode').textContent = `Kode: ${order.code}`;
        document.getElementById('statDate').textContent = order.orderDate;
        document.getElementById('statCustomer').textContent = order.customer;
        document.getElementById('statPrice').textContent = order.price;
        document.getElementById('statStatus').textContent = order.statusPengerjaan;
        
        document.getElementById('detNeedTitle').textContent = order.needTitle;
        document.getElementById('detNeedDesc').innerText = order.needDesc;


        const updateProgressSlider = document.getElementById('updateProgress');
        const progressSliderBox = document.getElementById('progressSliderBox');
        
        function applySliderColor(slider) {
            const val = slider.value;
            slider.style.background = `linear-gradient(to right, var(--primary) ${val}%, #E2E8F0 ${val}%)`;
            document.getElementById('progressText').textContent = `${val}%`;
        }
        if (updateProgressSlider) updateProgressSlider.addEventListener('input', function() { applySliderColor(this); });


        const stepperContainer = document.getElementById('stepperContainer');
        function renderStepper() {
            stepperContainer.innerHTML = '';
            const totalSelesai = order.stages.filter(s => s.status === 'Selesai').length;
            document.getElementById('stepperSubtitle').textContent = `${totalSelesai} dari ${order.stages.length} tahap selesai`;

            order.stages.forEach(stage => {
                let circleClass = 'belum'; let icon = stage.id;
                let statText = `<span style="font-size: 13px; color: var(--prod-text-sec); font-weight: 500;">Belum Dimulai</span>`;
                
                if (stage.status === 'Selesai') { 
                    circleClass = 'selesai'; icon = '<i class="ph ph-check"></i>'; 
                    statText = `<span style="font-size: 13px; color: var(--prod-success); font-weight: 500;">Selesai</span>`;
                } else if (stage.status === 'Sedang Dikerjakan') { 
                    circleClass = 'proses'; 
                    statText = `<span style="font-size: 13px; color: var(--primary); font-weight: 500;">Sedang Dikerjakan</span>`;
                } else if (stage.status === 'Dalam Revisi') {
                    circleClass = 'proses'; 
                    statText = `<span style="font-size: 13px; color: #D97706; font-weight: 500;">Dalam Revisi</span>`;
                }

                const isActive = stage.id === activeStageId ? 'active-step' : '';
                
                let extraContent = '';
                if (isActive || stage.status !== 'Belum Dimulai') {
                    if (stage.status === 'Selesai') {
                        extraContent = stage.note ? `<div style="background: #F8FAFC; padding: 12px; border-radius: 8px; font-size: 13px; border: 1px solid var(--prod-border); margin-top: 12px;"><strong style="color:var(--prod-text-main);">Catatan:</strong> ${stage.note}</div>` : '';
                    } else if (stage.status === 'Sedang Dikerjakan' || stage.status === 'Dalam Revisi') {
                        extraContent = `
                            <div class="mini-progress-bg"><div class="mini-progress-fill" style="width: ${stage.progress}%;"></div></div>
                            <div style="font-size: 12px; color: var(--primary); font-weight: 600;">Progress ${stage.progress}%</div>
                            ${stage.note ? `<div style="font-size: 13px; color: var(--prod-text-sec); margin-top: 8px;"><strong style="color:var(--prod-text-main);">Catatan:</strong> ${stage.note}</div>` : ''}
                        `;
                    }
                }

                stepperContainer.innerHTML += `
                    <div class="stepper-item ${isActive}" data-id="${stage.id}">
                        <div class="stepper-line"></div>
                        <div class="stepper-circle ${circleClass}">${icon}</div>
                        <div style="flex-grow: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <div>
                                    <div style="font-weight: 700; color: var(--prod-text-main); font-size: 15px; margin-bottom: 4px;">Tahap ${stage.id}: ${stage.name}</div>
                                    ${stage.status === 'Selesai' ? `<div style="font-size: 12px; color: var(--prod-success);"><i class="ph ph-check"></i> Selesai • ${stage.date}</div>` : `<div style="font-size: 12px; color: var(--prod-text-sec);">${stage.status}</div>`}
                                </div>
                                ${statText}
                            </div>
                            ${extraContent}
                        </div>
                    </div>
                `;
            });


            document.querySelectorAll('.stepper-item').forEach(el => {
                el.addEventListener('click', function() {
                    activeStageId = parseInt(this.getAttribute('data-id'));
                    renderStepper(); populateForm(); 
                });
            });
        }


        function populateForm() {
            const stage = order.stages.find(s => s.id === activeStageId);
            document.getElementById('formSubtitle').textContent = `Memperbarui: Tahap ${stage.id} — ${stage.name}`;
            document.getElementById('selectedStageBox').textContent = `Tahap ${stage.id}: ${stage.name}`;
            
            document.getElementById('updateStatus').disabled = false;
            document.getElementById('updateNote').disabled = false;
            document.getElementById('btnSimpanUpdate').disabled = false;
            document.getElementById('activeStageId').value = stage.id;
            
            document.getElementById('updateStatus').value = stage.status;
            document.getElementById('updateNote').value = stage.note;


            if(stage.status === 'Belum Dimulai') {
                progressSliderBox.style.display = 'none';
            } else {
                progressSliderBox.style.display = 'block';
                updateProgressSlider.disabled = false;
                updateProgressSlider.value = stage.status === 'Selesai' ? 100 : stage.progress;
                if(stage.status === 'Selesai') updateProgressSlider.disabled = true;
                applySliderColor(updateProgressSlider);
            }
        }

        renderStepper(); populateForm();


        document.getElementById('formUpdateProgress').addEventListener('submit', function(e) {
            e.preventDefault();
            const stageId = parseInt(document.getElementById('activeStageId').value);
            const newStatus = document.getElementById('updateStatus').value;
            const newProgress = newStatus === 'Belum Dimulai' ? 0 : (newStatus === 'Selesai' ? 100 : document.getElementById('updateProgress').value);
            
            const stageIndex = order.stages.findIndex(s => s.id === stageId);
            order.stages[stageIndex].status = newStatus;
            order.stages[stageIndex].progress = newProgress;
            order.stages[stageIndex].note = document.getElementById('updateNote').value;
            

            if(newStatus === 'Selesai') order.stages[stageIndex].date = '27 Agustus 2026';


            order.statusPengerjaan = newStatus;
            document.getElementById('statStatus').textContent = newStatus;
            document.getElementById('heroStatusPengerjaan').textContent = newStatus;

            dataOrders[orderIndex] = order;
            localStorage.setItem('produser_orders', JSON.stringify(dataOrders));
            
            renderStepper(); populateForm();
            
            const toast = document.getElementById('toastUpdate');
            toast.textContent = '✓ Perubahan progress berhasil disimpan.';
            toast.style.backgroundColor = '#16A34A';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        });


        document.getElementById('updateStatus').addEventListener('change', function() {
            if(this.value === 'Belum Dimulai' || this.value === 'Selesai') { 
                progressSliderBox.style.display = 'none'; 
            } else { 
                progressSliderBox.style.display = 'block'; 
                updateProgressSlider.disabled = false;
            }
        });
    }

    // ================= HALAMAN PRODUK/JASA SAYA =================
    const katalogContainer = document.getElementById('katalogContainer');
    if (katalogContainer) {
        const dProduk = JSON.parse(localStorage.getItem('rpl_produk')) || [
            { id: 'p1', type: 'Produk', name: 'Aplikasi Kasir', desc: 'Sistem kasir digital untuk UMKM.', price: 'Rp 2.500.000', img: 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&q=80' },
            { id: 'p2', type: 'Produk', name: 'Desain Logo & Branding', desc: 'Paket identitas visual profesional.', price: 'Rp 750.000', img: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=400&q=80' }
        ];
        const dJasa = JSON.parse(localStorage.getItem('rpl_jasa')) || [
            { id: 'j1', type: 'Jasa', name: 'Website Edukasi', desc: 'Pembuatan website profesional untuk lembaga pendidikan.', price: 'Rp 3.500.000', img: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&q=80' },
            { id: 'j2', type: 'Jasa', name: 'Aplikasi Mobile Sekolah', desc: 'Pembuatan aplikasi absensi dan jadwal untuk siswa.', price: 'Rp 7.000.000', img: 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=400&q=80' }
        ];
        
        const myKatalog = [...dProduk, ...dJasa];
        const searchInput = document.getElementById('searchKatalogProduser');
        const emptyKatalog = document.getElementById('emptyKatalog');

        function renderKatalog() {
            katalogContainer.innerHTML = '';
            const searchVal = searchInput ? searchInput.value.toLowerCase() : '';
            
            const filteredData = myKatalog.filter(k => k.name.toLowerCase().includes(searchVal));

            if (filteredData.length === 0) {
                emptyKatalog.style.display = 'block';
                katalogContainer.style.display = 'none';
            } else {
                emptyKatalog.style.display = 'none';
                katalogContainer.style.display = 'grid';

                filteredData.forEach(item => {
                    const badgeClass = item.type === 'Produk' ? 'badge-tipe-produk-new' : 'badge-tipe-jasa-new';
                    katalogContainer.innerHTML += `
                        <div class="tefa-card" style="background: white; overflow: hidden; display: flex; flex-direction: column;">
                            <img src="${item.img}" alt="${item.name}" style="width: 100%; height: 180px; object-fit: cover;">
                            <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                    <h3 style="font-size: 16px; color: var(--prod-text-main); margin: 0;">${item.name}</h3>
                                </div>
                                <div style="margin-bottom: 12px;"><span class="${badgeClass}">${item.type}</span></div>
                                <p style="font-size: 13px; color: var(--prod-text-sec); margin-bottom: 20px; flex-grow: 1;">${item.desc.substring(0, 80)}...</p>
                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--prod-border); padding-top: 16px;">
                                    <span style="font-weight: 700; color: var(--primary); font-size: 14px;">${item.price}</span>
                                    <button class="btn-outline btn-detail-katalog" data-id="${item.id}" style="padding: 6px 12px; font-size: 12px;">Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    `;
                });


                document.querySelectorAll('.btn-detail-katalog').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const selectedItem = myKatalog.find(k => k.id === id);
                        localStorage.setItem('produser_selected_katalog', JSON.stringify(selectedItem));
                        window.location.href = '/produser/katalog/detail';
                    });
                });
            }
        }
        renderKatalog();
        if (searchInput) searchInput.addEventListener('keyup', renderKatalog);
    }

    // ================= HALAMAN DETAIL KATALOG =================
    const detKatalogName = document.getElementById('detKatalogName');
    if (detKatalogName) {
        const item = JSON.parse(localStorage.getItem('produser_selected_katalog'));
        if (item) {
            document.getElementById('detKatalogImg').src = item.img;
            detKatalogName.textContent = item.name;
            document.getElementById('detKatalogTypeBadge').textContent = item.type;
            document.getElementById('detKatalogType').textContent = item.type;
            document.getElementById('detKatalogCode').textContent = item.type === 'Produk' ? 'Kode: PRD-003' : 'Kode: PRD-001';
            document.getElementById('detKatalogPrice').textContent = item.price;
            document.getElementById('detKatalogDesc').textContent = item.desc;
            document.getElementById('detKatalogKategori').textContent = item.type === 'Produk' ? 'Graphic Design' : 'Web Development';


            const features = item.type === 'Jasa' ? 
                ['Responsive Design (Mobile-Friendly)', 'CMS untuk Pengelolaan Konten', 'SEO Friendly', 'SSL Certificate', '3 Bulan Free Maintenance'] : 
                ['3 Pilihan Konsep Logo', 'Revisi Maksimal 3 Kali', 'File Master (.AI, .EPS)', 'Panduan Warna & Tipografi', 'Desain Kartu Nama'];
            
            document.getElementById('detKatalogFeatures').innerHTML = features.map(f => `<li><i class="ph ph-check-circle"></i> ${f}</li>`).join('');


            const relatedOrders = dataOrders.filter(o => o.productName === item.name);
            document.getElementById('detKatalogTotalOrders').textContent = relatedOrders.length;
            document.getElementById('totalRelatedOrders').textContent = relatedOrders.length;

            const relatedTable = document.getElementById('relatedOrderTable');
            relatedTable.innerHTML = '';
            
            if(relatedOrders.length === 0) {
                relatedTable.innerHTML = `<tr><td colspan="6" style="text-align: center; color: var(--prod-text-sec); padding: 24px;">Belum ada pesanan terkait.</td></tr>`;
            } else {
                relatedOrders.forEach(order => {
                    const tClass = order.productType === 'Produk' ? 'badge-tipe-produk-new' : 'badge-tipe-jasa-new';
                    relatedTable.innerHTML += `
                        <tr>
                            <td style="font-weight: 600; color: var(--prod-text-sec);">${order.id}</td>
                            <td><div style="font-weight: 600; color: var(--prod-text-main); margin-bottom: 6px;">${order.productName}</div><span class="${tClass}">${order.productType}</span></td>
                            <td style="font-weight: 500; color: var(--prod-text-main);">${order.customer}</td>
                            <td><span class="${getBadge(order.statusPengerjaan)}">${order.statusPengerjaan}</span></td>
                            <td><span class="${getBadge(order.statusPesanan)}">${order.statusPesanan}</span></td>
                            <td style="text-align: center;"><a href="/produser/pesanan/detail?id=${order.id}" class="btn-light-blue">Lihat Detail</a></td>
                        </tr>
                    `;
                });
            }
        }
    }
});

// ================= MODAL KELOLA TAHAPAN (TAMBAHAN BARU DI LUAR DOMContentLoaded) =================

// Fungsi Membuka & Menutup Modal Kelola Tahapan
function openModalTahapan() {
    document.getElementById('modalKelolaTahapan').style.display = 'flex';
    renderTabelTahapanDummy();
}

function closeModalTahapan() {
    document.getElementById('modalKelolaTahapan').style.display = 'none';
}

// Fungsi Form Sub-Modal (Tambah/Edit)
function openFormTambahTahap() {
    document.getElementById('formTahapTitle').textContent = 'Tambah Tahap Baru';
    document.getElementById('editStageId').value = '';
    document.getElementById('inputNamaTahap').value = '';
    document.getElementById('inputStatusTahap').value = 'Belum Dimulai';
    document.getElementById('modalFormTahap').style.display = 'flex';
}

function closeFormTahap() {
    document.getElementById('modalFormTahap').style.display = 'none';
}

// Render tabel dummy untuk preview UI
function renderTabelTahapanDummy() {
    const tbody = document.getElementById('tabelTahapanBody');
    tbody.innerHTML = `
        <tr>
            <td style="padding: 12px;">1</td>
            <td style="padding: 12px; font-weight: 600;">Analisis Kebutuhan & Perancangan Sistem</td>
            <td style="padding: 12px;"><span style="background: #E0F2FE; color: #0369A1; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Selesai</span></td>
            <td style="padding: 12px; text-align: center;">
                <button onclick="alert('Fitur Edit')" style="background: none; border: none; color: #2563EB; cursor: pointer; margin-right: 8px;"><i class="ph ph-pencil-simple" style="font-size: 16px;"></i></button>
                <button onclick="alert('Fitur Hapus')" style="background: none; border: none; color: #DC2626; cursor: pointer;"><i class="ph ph-trash" style="font-size: 16px;"></i></button>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px;">2</td>
            <td style="padding: 12px; font-weight: 600;">Pengembangan Frontend & Backend</td>
            <td style="padding: 12px;"><span style="background: #FEF3C7; color: #D97706; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Sedang Dikerjakan</span></td>
            <td style="padding: 12px; text-align: center;">
                <button onclick="alert('Fitur Edit')" style="background: none; border: none; color: #2563EB; cursor: pointer; margin-right: 8px;"><i class="ph ph-pencil-simple" style="font-size: 16px;"></i></button>
                <button onclick="alert('Fitur Hapus')" style="background: none; border: none; color: #DC2626; cursor: pointer;"><i class="ph ph-trash" style="font-size: 16px;"></i></button>
            </td>
        </tr>
    `;
}