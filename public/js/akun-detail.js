function openModal(modalId){
    const modal=document.getElementById(modalId);
    if(modal)modal.classList.add('active');
}

function closeModal(modalId){
    const modal=document.getElementById(modalId);
    if(modal)modal.classList.remove('active');
}

document.addEventListener("DOMContentLoaded",function(){
    // TAMPILKAN / SEMBUNYIKAN JURUSAN SAAT EDIT
    const roleSelect=document.getElementById('roleSelect');
    const jurusanWrapper=document.getElementById('jurusanWrapper');
    const jurusanSelect=document.getElementById('jurusanSelect');

    if(roleSelect){
        function toggleJurusan(){
            if(roleSelect.value==='admin_jurusan'){
                if(jurusanWrapper)jurusanWrapper.style.display='block';
                if(jurusanSelect)jurusanSelect.removeAttribute('disabled');
            }else{
                if(jurusanWrapper)jurusanWrapper.style.display='none';
                if(jurusanSelect){
                    jurusanSelect.setAttribute('disabled','disabled');
                    jurusanSelect.value='';
                }
            }
        }

        roleSelect.addEventListener('change',toggleJurusan);
        toggleJurusan();
    }

    // TAMPILKAN / SEMBUNYIKAN FORM RESET PASSWORD
    const resetButton=document.getElementById('btnResetPassword');
    const resetForm=document.getElementById('resetPasswordForm');
    const cancelReset=document.getElementById('cancelReset');

    if(resetButton&&resetForm){
        resetButton.addEventListener('click',function(){
            resetForm.style.display='block';
        });
    }

    if(cancelReset&&resetForm){
        cancelReset.addEventListener('click',function(){
            resetForm.style.display='none';
        });
    }
});


// ==========================================================
// TAMBAHAN: FITUR LIGHTBOX (FOTO "NGAMBANG" BESAR KETIKA DIKLIK)
// Kode asli di atas 100% aman dan tidak disentuh!
// ==========================================================
document.addEventListener('DOMContentLoaded', function() {
    // 1. Buat elemen HTML untuk Modal Lightbox secara otomatis
    const modal = document.createElement('div');
    modal.className = 'image-lightbox-modal';
    modal.innerHTML = `
        <button class="lightbox-close">&times;</button>
        <img class="lightbox-content" src="" alt="Preview Besar">
    `;
    document.body.appendChild(modal);

    const lightboxImg = modal.querySelector('.lightbox-content');
    const closeBtn = modal.querySelector('.lightbox-close');

    // 2. Pilih semua gambar di slide utama maupun thumbnail
    const clickableImages = document.querySelectorAll('.carousel-slide img, .thumb-item img');

    // 3. Beri aksi saat gambar diklik
    clickableImages.forEach(img => {
        img.addEventListener('click', function() {
            lightboxImg.src = this.src; // Ambil sumber gambar yang diklik
            modal.classList.add('active'); // Tampilkan modal dengan animasi ngambang
        });
    });

    // 4. Tutup modal saat tombol 'X' diklik
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // 5. Tutup modal jika area gelap di luar gambar diklik
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // 6. Tutup modal menggunakan tombol ESC pada keyboard
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            modal.classList.remove('active');
        }
    });
});