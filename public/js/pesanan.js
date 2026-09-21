document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterJurusan = document.getElementById('filterJurusan');
    const table = document.getElementById('pesananTable');

    if (!table) {
        return;
    }

    const tableRows = document.querySelectorAll(
        '#pesananTable tbody tr.pesanan-row'
    );

    function filterTable() {
        const searchTerm = searchInput
            ? searchInput.value.toLowerCase().trim()
            : '';

        const statusTerm = filterStatus
            ? filterStatus.value.toLowerCase().trim()
            : 'semua';

        const jurusanTerm = filterJurusan
            ? filterJurusan.value.toLowerCase().trim()
            : 'semua';

        let visibleCount = 0;

        tableRows.forEach(row => {
            const id = row.querySelector('.col-id')
                ?.textContent
                .toLowerCase()
                .trim() || '';

            const nama = row.querySelector('.col-nama')
                ?.textContent
                .toLowerCase()
                .trim() || '';

            const produk = row.querySelector('.col-produk')
                ?.textContent
                .toLowerCase()
                .trim() || '';

            const jurusan = row.querySelector('.col-jurusan')
                ?.textContent
                .toLowerCase()
                .trim() || '';

            const statusSelect = row.querySelector('.col-status select');

            const status = statusSelect
                ? statusSelect.value.toLowerCase().trim()
                : '';

            const matchSearch =
                searchTerm === '' ||
                id.includes(searchTerm) ||
                nama.includes(searchTerm) ||
                produk.includes(searchTerm) ||
                jurusan.includes(searchTerm) ||
                status.includes(searchTerm);

            const matchStatus =
                statusTerm === 'semua' ||
                status === statusTerm;

            let matchJurusan = true;

            if (jurusanTerm !== 'semua') {
                const jurusanMap = {
                    'rpl': 'rekayasa perangkat lunak',
                    'tkj': 'teknik komputer dan jaringan',
                    'dkv': 'desain komunikasi visual',
                    'animasi': 'animasi',
                    'gim': 'gim',
                    'pspt': 'produksi dan siaran program televisi'
                };

                const namaJurusan = jurusanMap[jurusanTerm] || jurusanTerm;

                matchJurusan =
                    jurusan === namaJurusan ||
                    jurusan.includes(namaJurusan);
            }

            if (matchSearch && matchStatus && matchJurusan) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        let emptyRow = document.getElementById('emptyFilterRow');

        if (visibleCount === 0 && tableRows.length > 0) {
            if (!emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.id = 'emptyFilterRow';

                const emptyCell = document.createElement('td');
                emptyCell.colSpan = 9;
                emptyCell.style.textAlign = 'center';
                emptyCell.style.padding = '60px 20px';

                emptyCell.innerHTML = `
                    <h3 style="color: #1e293b; margin-bottom: 8px; font-size: 18px;">
                        Pesanan Tidak Ditemukan
                    </h3>
                    <p style="color: #64748b; font-size: 14px;">
                        Tidak ada pesanan yang sesuai dengan pencarian atau filter.
                    </p>
                `;

                emptyRow.appendChild(emptyCell);
                table.querySelector('tbody').appendChild(emptyRow);
            }

            emptyRow.style.display = '';
        } else if (emptyRow) {
            emptyRow.style.display = 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }

    if (filterStatus) {
        filterStatus.addEventListener('change', filterTable);
    }

    if (filterJurusan) {
        filterJurusan.addEventListener('change', filterTable);
    }

    filterTable();
});