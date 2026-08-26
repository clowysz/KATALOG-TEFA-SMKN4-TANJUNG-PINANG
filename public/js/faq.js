// Fungsi global untuk membuka dan menutup modal FAQ
function openFaqModal(modalId) {
    document.getElementById(modalId).classList.add('active');
}
function closeFaqModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

document.addEventListener("DOMContentLoaded", function() {
    const faqContainer = document.getElementById('faqContainer');
    const emptyFaq = document.getElementById('emptyFaq');
    const toast = document.getElementById('toastFaq');

    // Tampilkan Toast
    function showToast(message, isError = false) {
        toast.textContent = message;
        toast.style.backgroundColor = isError ? '#dc3545' : '#28a745';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // 10 Data FAQ Default dari Spesifikasi
    const defaultFAQs = [
        { id: 1, q: "Apa itu TEFA?", a: "TEFA (Teaching Factory) merupakan konsep pembelajaran berbasis dunia kerja yang memungkinkan kegiatan pembelajaran dilakukan dengan menerapkan standar dan suasana kerja nyata. Melalui TEFA, produk dan jasa yang dihasilkan dapat ditawarkan kepada masyarakat atau pengguna." },
        { id: 2, q: "Produk dan jasa apa saja yang tersedia di TEFA?", a: "Produk dan jasa yang tersedia bergantung pada jurusan dan layanan yang disediakan oleh TEFA. Informasi mengenai produk dan jasa dapat dilihat melalui katalog pada website TEFA." },
        { id: 3, q: "Bagaimana cara melihat produk atau jasa yang tersedia?", a: "Pengguna dapat membuka halaman katalog untuk melihat berbagai produk dan jasa yang tersedia. Pengguna juga dapat memilih produk atau jasa tertentu untuk melihat informasi lebih lengkap." },
        { id: 4, q: "Bagaimana cara melakukan pemesanan produk atau jasa?", a: "Dipastikan login terlebih dahulu lalu Pilih produk atau jasa yang diinginkan pada katalog, kemudian ikuti proses pemesanan yang tersedia pada website. Pastikan data pemesanan yang dimasukkan sudah benar sebelum mengirimkan pesanan." },
        { id: 5, q: "Apakah semua produk dan jasa dapat langsung dipesan?", a: "Tidak selalu. Ketersediaan dan proses pemesanan dapat berbeda untuk setiap produk atau jasa. Beberapa pesanan mungkin memerlukan konfirmasi dari pihak yang bertanggung jawab sebelum dapat diproses." },
        { id: 6, q: "Bagaimana cara mengetahui status pesanan?", a: "Status pesanan dapat diketahui melalui informasi pesanan pada website. Status akan diperbarui sesuai dengan proses yang dilakukan oleh pihak TEFA atau admin yang bertanggung jawab terhadap pesanan." },
        { id: 7, q: "Bagaimana cara menghubungi Customer Service?", a: "Pengguna dapat menghubungi Customer Service melalui informasi kontak yang tersedia pada website TEFA." },
        { id: 8, q: "Apakah transaksi dilakukan melalui website?", a: "Tidak. Customer akan di hubungi oleh pihak terkait jika pesanan sudah di konfirmasi." },
        { id: 9, q: "Bagaimana jika saya memiliki pertanyaan atau kendala terkait pesanan?", a: "Jika mengalami kendala atau memiliki pertanyaan mengenai pesanan, pengguna dapat menghubungi Customer service. Sertakan informasi pesanan agar kendala dapat ditangani dengan lebih mudah." },
        { id: 10, q: "Bagaimana cara mengetahui jurusan yang menyediakan suatu produk atau jasa?", a: "Informasi jurusan yang menyediakan produk atau jasa dapat dilihat pada detail katalog. Setiap produk atau jasa akan mencantumkan informasi mengenai jurusan atau pihak yang menyediakan layanan tersebut." }
    ];

    // Inisialisasi Data dari LocalStorage atau Data Default
    let faqs = JSON.parse(localStorage.getItem('tefa_faqs'));
    if (!faqs || faqs.length === 0) {
        faqs = defaultFAQs;
        localStorage.setItem('tefa_faqs', JSON.stringify(faqs));
    }

    // Fungsi Render Daftar FAQ ke HTML
    function renderFaqs() {
        faqContainer.innerHTML = '';
        if (faqs.length === 0) {
            emptyFaq.style.display = 'block';
        } else {
            emptyFaq.style.display = 'none';
            faqs.forEach(faq => {
                const item = document.createElement('div');
                item.className = 'faq-item';
                item.innerHTML = `
                    <div class="faq-question">${faq.q}</div>
                    <div class="faq-answer">${faq.a}</div>
                    <div class="faq-actions">
                        <button class="btn-outline btn-edit" data-id="${faq.id}">Edit</button>
                        <button class="btn-outline btn-delete" data-id="${faq.id}" style="color: #dc3545; border-color: #dc3545;">Hapus</button>
                    </div>
                `;
                faqContainer.appendChild(item);
            });
            attachActionListeners(); // Pasang event listener untuk tombol edit & hapus yang baru dirender
        }
    }

    // Pasang Event Listener untuk Tombol Edit dan Hapus di masing-masing item
    function attachActionListeners() {
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = parseInt(this.getAttribute('data-id'));
                const faq = faqs.find(f => f.id === id);
                if (faq) {
                    document.getElementById('editFaqId').value = faq.id;
                    document.getElementById('editQuestion').value = faq.q;
                    document.getElementById('editAnswer').value = faq.a;
                    openFaqModal('modalEditFaq');
                }
            });
        });

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = parseInt(this.getAttribute('data-id'));
                document.getElementById('deleteFaqId').value = id;
                openFaqModal('modalHapusFaq');
            });
        });
    }

    // Eksekusi Render Pertama Kali
    renderFaqs();

    // LOGIKA TAMBAH FAQ
    document.getElementById('formTambahFaq').addEventListener('submit', function(e) {
        e.preventDefault();
        const newId = faqs.length > 0 ? Math.max(...faqs.map(f => f.id)) + 1 : 1;
        const newFaq = {
            id: newId,
            q: document.getElementById('addQuestion').value.trim(),
            a: document.getElementById('addAnswer').value.trim()
        };
        
        faqs.unshift(newFaq); // Tambah ke posisi paling atas
        localStorage.setItem('tefa_faqs', JSON.stringify(faqs));
        renderFaqs();
        
        this.reset();
        closeFaqModal('modalTambahFaq');
        showToast('✓ FAQ berhasil ditambahkan.');
    });

    // LOGIKA EDIT FAQ
    document.getElementById('formEditFaq').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = parseInt(document.getElementById('editFaqId').value);
        const index = faqs.findIndex(f => f.id === id);
        
        if(index !== -1) {
            faqs[index].q = document.getElementById('editQuestion').value.trim();
            faqs[index].a = document.getElementById('editAnswer').value.trim();
            localStorage.setItem('tefa_faqs', JSON.stringify(faqs));
            renderFaqs();
            
            closeFaqModal('modalEditFaq');
            showToast('✓ Perubahan FAQ berhasil disimpan.');
        }
    });

    // LOGIKA HAPUS FAQ
    document.getElementById('btnConfirmDeleteFaq').addEventListener('click', function() {
        const id = parseInt(document.getElementById('deleteFaqId').value);
        faqs = faqs.filter(f => f.id !== id);
        localStorage.setItem('tefa_faqs', JSON.stringify(faqs));
        renderFaqs();
        
        closeFaqModal('modalHapusFaq');
        showToast('✓ FAQ berhasil dihapus.');
    });
});