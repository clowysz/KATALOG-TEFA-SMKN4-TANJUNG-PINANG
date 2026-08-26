document.addEventListener("DOMContentLoaded", function() {
    // ================= LOGIKA HALAMAN DAFTAR AKUN =================
    const searchAkun = document.getElementById('searchAkun');
    const filterRole = document.getElementById('filterRole');
    const filterStatus = document.getElementById('filterStatusAkun');
    const tableRows = document.querySelectorAll('#akunTable tbody tr');
    const emptyAkun = document.getElementById('emptyAkun');
    const akunTable = document.getElementById('akunTable');

    function filterAkunTable() {
        if(!akunTable) return; // Skip jika bukan di halaman Daftar Akun
        
        const searchTerm = searchAkun.value.toLowerCase();
        const roleTerm = filterRole.value;
        const statusTerm = filterStatus.value;
        let visibleCount = 0;

        tableRows.forEach(row => {
            const nama = row.querySelector('.col-nama').textContent.toLowerCase();
            const email = row.querySelector('.col-email').textContent.toLowerCase();
            const role = row.querySelector('.col-role').textContent;
            const status = row.querySelector('.col-status').textContent;

            const matchSearch = nama.includes(searchTerm) || email.includes(searchTerm);
            const matchRole = roleTerm === 'Semua' || role === roleTerm;
            const matchStatus = statusTerm === 'Semua' || status === statusTerm;

            if (matchSearch && matchRole && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            emptyAkun.style.display = 'block';
            akunTable.style.display = 'none';
        } else {
            emptyAkun.style.display = 'none';
            akunTable.style.display = 'table';
        }
    }

    if(searchAkun) searchAkun.addEventListener('keyup', filterAkunTable);
    if(filterRole) filterRole.addEventListener('change', filterAkunTable);
    if(filterStatus) filterStatus.addEventListener('change', filterAkunTable);


    // ================= LOGIKA HALAMAN TAMBAH AKUN =================
    const roleSelect = document.getElementById('role');
    const jurusanContainer = document.getElementById('jurusanContainer');
    const jurusanSelect = document.getElementById('jurusan');
    const helpText = document.getElementById('helpTextJurusan');
    const formTambah = document.getElementById('formTambahAkun');
    const toast = document.getElementById('toastSuccess');

    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            if (this.value === 'Admin TEFA') {
                jurusanContainer.style.display = 'none';
                jurusanSelect.required = false;
                helpText.textContent = "Admin TEFA tidak terikat pada jurusan tertentu.";
            } else if (this.value === 'Admin Jurusan') {
                jurusanContainer.style.display = 'block';
                jurusanSelect.required = true;
                helpText.textContent = "Pilih jurusan yang menjadi tanggung jawab akun ini.";
            }
        });
    }

    if (formTambah) {
        formTambah.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            // Tampilkan Toast
            toast.classList.add('show');
            
            // Simulasi redirect ke halaman Daftar Akun setelah 2 detik
            setTimeout(function() {
                window.location.href = '/akun';
            }, 2000);
        });
    }
    // ================= SINKRONISASI PROTOTYPE (LOCAL STORAGE) =================
    
    // 1. Simpan data baris tabel ke LocalStorage saat tombol Lihat Detail diklik
    const btnLihatDetail = document.querySelectorAll('.btn-lihat-detail');
    btnLihatDetail.forEach(btn => {
        btn.addEventListener('click', function() {
            const tr = this.closest('tr');
            const userData = {
                nama: tr.querySelector('.col-nama').textContent,
                email: tr.querySelector('.col-email').textContent,
                role: tr.querySelector('.col-role').textContent,
                jurusan: tr.querySelector('.col-jurusan').textContent,
                status: tr.querySelector('.col-status').textContent.trim()
            };
            // Simpan ke memori browser
            localStorage.setItem('viewedUser', JSON.stringify(userData));
        });
    });

    // 2. Saat halaman Daftar Akun dimuat, cek apakah ada akun yang statusnya baru saja dihapus
    const updatedUser = JSON.parse(localStorage.getItem('updatedUser'));
    if (updatedUser && akunTable) {
        document.querySelectorAll('#akunTable tbody tr').forEach(tr => {
            // Cari baris yang email-nya sama dengan yang baru saja di-update
            if (tr.querySelector('.col-email').textContent === updatedUser.email) {
                const badge = tr.querySelector('.col-status span');
                badge.textContent = updatedUser.status;
                badge.className = updatedUser.status === 'Aktif' ? 'badge badge-active' : 'badge badge-inactive';
            }
        });
    }
});