function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

document.addEventListener("DOMContentLoaded", function() {
    const toast = document.getElementById('toastAction');
    
    // --- AMBIL DATA DARI LOCAL STORAGE UNTUK MENAMPILKAN DETAIL ---
    const viewedUser = JSON.parse(localStorage.getItem('viewedUser'));
    if (viewedUser) {
        // Timpa teks HTML bawaan dengan data yang diklik dari Daftar Akun
        document.getElementById('detNama').textContent = viewedUser.nama;
        document.getElementById('detEmail').textContent = viewedUser.email;
        document.getElementById('detRole').textContent = viewedUser.role;
        document.getElementById('detJurusan').textContent = viewedUser.jurusan;

        const badge = document.getElementById('statusBadge');
        badge.textContent = viewedUser.status;
        badge.className = viewedUser.status === 'Aktif' ? 'badge badge-active' : 'badge badge-inactive';
    }

    // --- LOGIKA SHOW PASSWORD MODAL ---
    const toggleModalPass = document.getElementById('toggleModalPass');
    const newPass = document.getElementById('newPass');
    const confirmPass = document.getElementById('confirmPass');

    if(toggleModalPass) {
        toggleModalPass.addEventListener('change', function() {
            const type = this.checked ? 'text' : 'password';
            newPass.type = type;
            confirmPass.type = type;
        });
    }

    // --- LOGIKA RESET PASSWORD ---
    const formReset = document.getElementById('formResetPassword');
    if(formReset) {
        formReset.addEventListener('submit', function(e) {
            e.preventDefault();
            if(newPass.value !== confirmPass.value) {
                toast.textContent = '❌ Password tidak cocok.';
                toast.style.backgroundColor = '#dc3545';
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 3000);
                return;
            }
            closeModal('modalReset');
            toast.textContent = '✓ Password berhasil diubah.';
            toast.style.backgroundColor = '#28a745';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
            formReset.reset();
        });
    }

    // --- LOGIKA HAPUS AKSES ---
    const btnHapus = document.getElementById('btnConfirmHapus');
    if(btnHapus) {
        btnHapus.addEventListener('click', function() {
            closeModal('modalHapus');
            
            // Ubah badge status di halaman detail saat ini
            const badge = document.getElementById('statusBadge');
            badge.textContent = 'Tidak Aktif';
            badge.className = 'badge badge-inactive';
            
            // Simpan perubahan ke LocalStorage agar halaman Daftar Akun tahu!
            if (viewedUser) {
                viewedUser.status = 'Tidak Aktif';
                localStorage.setItem('updatedUser', JSON.stringify(viewedUser)); // Untuk halaman index
                localStorage.setItem('viewedUser', JSON.stringify(viewedUser));  // Untuk halaman detail
            }

            toast.textContent = '✓ Akses akun berhasil dihapus.';
            toast.style.backgroundColor = '#28a745';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        });
    }
});