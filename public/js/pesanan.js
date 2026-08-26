document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterJurusan = document.getElementById('filterJurusan');
    const tableRows = document.querySelectorAll('#pesananTable tbody tr');
    const emptyState = document.getElementById('emptyState');
    const table = document.getElementById('pesananTable');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = filterStatus.value;
        const jurusanTerm = filterJurusan.value;
        let visibleCount = 0;

        tableRows.forEach(row => {
            const id = row.querySelector('.col-id').textContent.toLowerCase();
            const nama = row.querySelector('.col-nama').textContent.toLowerCase();
            const produk = row.querySelector('.col-produk').textContent.toLowerCase();
            const status = row.querySelector('.col-status').textContent;
            const jurusan = row.querySelector('.col-jurusan').textContent;

            const matchSearch = id.includes(searchTerm) || nama.includes(searchTerm) || produk.includes(searchTerm);
            const matchStatus = statusTerm === 'Semua' || status === statusTerm;
            const matchJurusan = jurusanTerm === 'Semua' || jurusan === jurusanTerm;

            if (matchSearch && matchStatus && matchJurusan) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Tampilkan empty state jika tidak ada data yang cocok
        if (visibleCount === 0) {
            emptyState.style.display = 'block';
            table.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            table.style.display = 'table';
        }
    }

    // Jalankan filter saat input/dropdown diubah
    if(searchInput) searchInput.addEventListener('keyup', filterTable);
    if(filterStatus) filterStatus.addEventListener('change', filterTable);
    if(filterJurusan) filterJurusan.addEventListener('change', filterTable);
});