document.addEventListener("DOMContentLoaded", function() {
    const formUpdate = document.getElementById('formUpdateStatus');
    const toast = document.getElementById('toastSuccess');
    const statusSelect = document.getElementById('statusSelect');
    const currentBadge = document.getElementById('currentStatusBadge');

    if (formUpdate) {
        formUpdate.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah halaman ter-refresh saat disubmit

            // 1. Tampilkan Toast Notification
            toast.classList.add('show');

            // 2. Sembunyikan Toast secara otomatis setelah 3 detik
            setTimeout(function() {
                toast.classList.remove('show');
            }, 3000);

            // 3. (Opsional untuk Prototype) Update teks pada badge status di atas
            const selectedStatus = statusSelect.value;
            currentBadge.textContent = selectedStatus;
            
            // Ubah warna badge sesuai status yang dipilih
            currentBadge.className = 'badge'; // Reset class
            if(selectedStatus === 'Menunggu Konfirmasi') currentBadge.classList.add('badge-pending');
            else if(selectedStatus === 'Dikonfirmasi') currentBadge.classList.add('badge-confirmed');
            else if(selectedStatus === 'Diproses') currentBadge.classList.add('badge-processing');
            else if(selectedStatus === 'Selesai') currentBadge.classList.add('badge-done');
            else if(selectedStatus === 'Dibatalkan') currentBadge.classList.add('badge-cancelled');
        });
    }
});