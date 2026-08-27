function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const accountId = urlParams.get('id');
    
    let dataAkun = JSON.parse(localStorage.getItem('rpl_akun')) || [];
    const account = dataAkun.find(a => a.id === accountId);
    
    const toast = document.getElementById('toastAction');
    function showToast(msg) {
        if(!toast) return;
        toast.textContent = msg;
        toast.style.backgroundColor = '#28a745';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    if (!account) return; // Jika tidak ada ID, hentikan proses

    // ================= HALAMAN DETAIL =================
    const detNama = document.getElementById('detNama');
    if (detNama) {
        detNama.textContent = account.nama;
        document.getElementById('detEmail').textContent = account.email;
        
        const badgeStatus = document.getElementById('detStatus');
        if (badgeStatus) {
            badgeStatus.textContent = account.status;
            badgeStatus.className = account.status === 'Aktif' ? 'badge badge-active' : 'badge badge-grey';
        }

        // Render Chip di Detail
        const semuaLayanan = [...JSON.parse(localStorage.getItem('rpl_produk')) || [], ...JSON.parse(localStorage.getItem('rpl_jasa')) || []];
        const layananHtml = account.layanan.map(l => {
            const layananObj = semuaLayanan.find(s => s.name === l);
            const typeClass = (layananObj && layananObj.type === 'Produk') ? 'badge-tipe-produk' : 'badge-tipe-jasa';
            const typeName = (layananObj && layananObj.type) ? layananObj.type : 'Layanan';
            return `<div class="chip-label" style="padding: 6px 16px; cursor: default; display: inline-flex;"><span class="${typeClass}">${typeName}</span> ${l}</div>`;
        }).join('');
        
        const detLayanan = document.getElementById('detLayanan');
        if (detLayanan) {
            detLayanan.innerHTML = layananHtml;
        }

        // Atur Tombol Edit & Status
        const btnToEdit = document.getElementById('btnToEdit');
        if (btnToEdit) {
            btnToEdit.addEventListener('click', () => {
                window.location.href = `/jurusan-admin/akun/edit?id=${account.id}`;
            });
        }

        const btnHapusAkses = document.getElementById('btnHapusAkses');
        const btnAktifkan = document.getElementById('btnAktifkan');
        const btnConfirmStatus = document.getElementById('btnConfirmStatus');

        if (account.status === 'Aktif') {
            if (btnHapusAkses) btnHapusAkses.style.display = 'flex';
            if (btnAktifkan) btnAktifkan.style.display = 'none';
        } else {
            if (btnHapusAkses) btnHapusAkses.style.display = 'none';
            if (btnAktifkan) btnAktifkan.style.display = 'flex';
        }

        // Hapus Akses (Ubah ke Tidak Aktif)
        if (btnConfirmStatus) {
            btnConfirmStatus.addEventListener('click', function() {
                account.status = 'Tidak Aktif';
                localStorage.setItem('rpl_akun', JSON.stringify(dataAkun));
                closeModal('modalHapus');
                showToast('✓ Akses akun berhasil dihapus.');
                setTimeout(() => location.reload(), 1500);
            });
        }

        // Aktifkan Kembali
        if (btnAktifkan) {
            btnAktifkan.addEventListener('click', function() {
                account.status = 'Aktif';
                localStorage.setItem('rpl_akun', JSON.stringify(dataAkun));
                showToast('✓ Akses akun berhasil diaktifkan.');
                setTimeout(() => location.reload(), 1500);
            });
        }

        // Reset Password
        const formReset = document.getElementById('formResetPassword');
        if (formReset) {
            const toggleModalPass = document.getElementById('toggleModalPass');
            const newPass = document.getElementById('newPass');
            const confirmPass = document.getElementById('confirmPass');
            const errorReset = document.getElementById('errorReset');

            if (toggleModalPass) {
                toggleModalPass.addEventListener('change', function() {
                    const type = this.checked ? 'text' : 'password';
                    newPass.type = type;
                    confirmPass.type = type;
                });
            }

            formReset.addEventListener('submit', function(e) {
                e.preventDefault();
                if (newPass.value !== confirmPass.value) {
                    errorReset.style.display = 'block';
                    return;
                }
                errorReset.style.display = 'none';
                account.password = newPass.value; // Tersimpan di database lokal
                localStorage.setItem('rpl_akun', JSON.stringify(dataAkun));
                closeModal('modalReset');
                showToast('✓ Password berhasil diubah.');
                formReset.reset();
            });
        }
    }

    // ================= HALAMAN EDIT =================
    const formEdit = document.getElementById('formEditAkunJurusan');
    if (formEdit) {
        document.getElementById('editNama').value = account.nama;
        document.getElementById('editEmail').value = account.email;
        
        // Set Radio Button Status (UI Modern)
        if (account.status === 'Aktif') { 
            document.getElementById('statusAktif').checked = true; 
        } else { 
            document.getElementById('statusTidakAktif').checked = true; 
        }

        const btnBack = document.getElementById('btnBack');
        if (btnBack) {
            btnBack.addEventListener('click', () => {
                window.location.href = `/jurusan-admin/akun/detail?id=${account.id}`;
            });
        }

        // Render Checkbox Layanan dengan Ikon ✓
        const editCheckboxContainer = document.getElementById('editCheckboxContainer');
        const semuaLayanan = [...JSON.parse(localStorage.getItem('rpl_produk')) || [], ...JSON.parse(localStorage.getItem('rpl_jasa')) || []];

        editCheckboxContainer.innerHTML = '';
        semuaLayanan.forEach((item, index) => {
            const badgeClass = item.type === 'Produk' ? 'badge-tipe-produk' : 'badge-tipe-jasa';
            const isChecked = account.layanan.includes(item.name);
            const checkIcon = isChecked ? '<i class="ph ph-check" style="margin-right:6px; font-weight:bold;"></i>' : '';
            
            editCheckboxContainer.innerHTML += `
                <div>
                    <input type="checkbox" id="edit_lay_${index}" name="editLayananAkun" value="${item.name}" class="chip-input" ${isChecked ? 'checked' : ''}>
                    <label for="edit_lay_${index}" class="chip-label">
                        ${checkIcon} <span class="${badgeClass}">${item.type}</span> ${item.name}
                    </label>
                </div>
            `;
        });

        // Event listener agar ikon ✓ muncul/hilang saat chip diklik
        document.querySelectorAll('input[name="editLayananAkun"]').forEach(input => {
            input.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if(this.checked) {
                    label.insertAdjacentHTML('afterbegin', '<i class="ph ph-check" style="margin-right:6px; font-weight:bold;"></i>');
                } else {
                    const icon = label.querySelector('.ph-check');
                    if(icon) icon.remove();
                }
            });
        });

        formEdit.addEventListener('submit', function(e) {
            e.preventDefault();
            const checkedLayanan = Array.from(document.querySelectorAll('input[name="editLayananAkun"]:checked')).map(cb => cb.value);
            const errorEditLayanan = document.getElementById('errorEditLayanan');

            if (checkedLayanan.length === 0) {
                errorEditLayanan.style.display = 'block';
                return;
            }
            errorEditLayanan.style.display = 'none';

            account.nama = document.getElementById('editNama').value;
            account.email = document.getElementById('editEmail').value;
            
            // Ambil Status dari Radio Button
            const statusRadio = document.querySelector('input[name="editStatusRadio"]:checked');
            if (statusRadio) {
                account.status = statusRadio.value;
            }
            account.layanan = checkedLayanan;

            localStorage.setItem('rpl_akun', JSON.stringify(dataAkun));
            showToast('✓ Perubahan berhasil disimpan.');
            setTimeout(() => { window.location.href = `/jurusan-admin/akun/detail?id=${account.id}`; }, 1500);
        });
    }
});