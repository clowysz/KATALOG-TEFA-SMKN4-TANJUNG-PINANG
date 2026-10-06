function openModal(modalId){
    const modal=document.getElementById(modalId);
    if(modal)modal.classList.add('active');
}

function closeModal(modalId){
    const modal=document.getElementById(modalId);
    if(modal)modal.classList.remove('active');
}


// ==========================================================
// VALIDASI PASSWORD DAN KONFIRMASI PASSWORD
// ==========================================================

const passwordInput = document.getElementById('password');
const passwordConfirmationInput = document.getElementById('password_confirmation');

if (passwordInput) {
    passwordInput.addEventListener('invalid', function () {
        if (this.validity.valueMissing) {
            this.setCustomValidity('Password baru wajib diisi.');
        } else if (this.validity.tooShort) {
            this.setCustomValidity('Password harus memiliki minimal 6 karakter.');
        }
    });

    passwordInput.addEventListener('input', function () {
        if (this.value.length === 0) {
            this.setCustomValidity('Password baru wajib diisi.');
        } else if (this.value.length < 6) {
            this.setCustomValidity('Password harus memiliki minimal 6 karakter.');
        } else {
            this.setCustomValidity('');
        }

        if (
            passwordConfirmationInput &&
            passwordConfirmationInput.value.length > 0
        ) {
            if (passwordConfirmationInput.value !== this.value) {
                passwordConfirmationInput.setCustomValidity(
                    'Konfirmasi password tidak cocok.'
                );
            } else if (passwordConfirmationInput.value.length < 6) {
                passwordConfirmationInput.setCustomValidity(
                    'Konfirmasi password harus memiliki minimal 6 karakter.'
                );
            } else {
                passwordConfirmationInput.setCustomValidity('');
            }
        }
    });
}

if (passwordConfirmationInput) {
    passwordConfirmationInput.addEventListener('invalid', function () {
        if (this.validity.valueMissing) {
            this.setCustomValidity('Konfirmasi password wajib diisi.');
        } else if (this.validity.tooShort) {
            this.setCustomValidity(
                'Konfirmasi password harus memiliki minimal 6 karakter.'
            );
        }
    });

    passwordConfirmationInput.addEventListener('input', function () {
        if (this.value.length === 0) {
            this.setCustomValidity('Konfirmasi password wajib diisi.');
        } else if (this.value.length < 6) {
            this.setCustomValidity(
                'Konfirmasi password harus memiliki minimal 6 karakter.'
            );
        } else if (
            passwordInput &&
            this.value !== passwordInput.value
        ) {
            this.setCustomValidity(
                'Konfirmasi password tidak cocok.'
            );
        } else {
            this.setCustomValidity('');
        }
    });
}


document.addEventListener("DOMContentLoaded", function () {

    // ==========================================================
    // TAMPILKAN / SEMBUNYIKAN JURUSAN SAAT EDIT
    // ==========================================================

    const roleSelect = document.getElementById('roleSelect');
    const jurusanWrapper = document.getElementById('jurusanWrapper');
    const jurusanSelect = document.getElementById('jurusanSelect');


    // ==========================================================
    // VALIDASI JURUSAN SAAT EDIT
    // ==========================================================

    if (jurusanSelect) {

        jurusanSelect.addEventListener('invalid', function () {

            if (
                roleSelect &&
                roleSelect.value === 'admin_jurusan' &&
                this.validity.valueMissing
            ) {
                this.setCustomValidity(
                    'Jurusan wajib dipilih untuk Admin Jurusan.'
                );
            } else {
                this.setCustomValidity('');
            }
        });

        jurusanSelect.addEventListener('change', function () {
            this.setCustomValidity('');
        });
    }


    // ==========================================================
    // TOGGLE JURUSAN
    // ==========================================================

    if(roleSelect){

        function toggleJurusan(){

            if(roleSelect.value === 'admin_jurusan'){

                if(jurusanWrapper){
                    jurusanWrapper.style.display = 'block';
                }

                if(jurusanSelect){
                    jurusanSelect.removeAttribute('disabled');
                    jurusanSelect.setAttribute('required', 'required');
                }

            }else{

                if(jurusanWrapper){
                    jurusanWrapper.style.display = 'none';
                }

                if(jurusanSelect){
                    jurusanSelect.setAttribute('disabled', 'disabled');
                    jurusanSelect.removeAttribute('required');
                    jurusanSelect.value = '';
                    jurusanSelect.setCustomValidity('');
                }
            }
        }

        roleSelect.addEventListener('change', function () {

            roleSelect.setCustomValidity('');

            toggleJurusan();

        });

        toggleJurusan();
    }


    // ==========================================================
    // TAMPILKAN / SEMBUNYIKAN FORM RESET PASSWORD
    // ==========================================================

    const resetButton = document.getElementById('btnResetPassword');
    const resetForm = document.getElementById('resetPasswordForm');
    const cancelReset = document.getElementById('cancelReset');

    if(resetButton && resetForm){
        resetButton.addEventListener('click',function(){
            resetForm.style.display='block';
        });
    }

    if(cancelReset && resetForm){
        cancelReset.addEventListener('click',function(){
            resetForm.style.display='none';
        });
    }

});


// ==========================================================
// FITUR LIGHTBOX
// FOTO "NGAMBANG" BESAR KETIKA DIKLIK
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


    // 2. Ambil elemen gambar dan tombol close

    const lightboxImg = modal.querySelector('.lightbox-content');
    const closeBtn = modal.querySelector('.lightbox-close');


    // 3. Pilih semua gambar di slide utama maupun thumbnail

    const clickableImages = document.querySelectorAll(
        '.carousel-slide img, .thumb-item img'
    );


    // 4. Beri aksi saat gambar diklik

    clickableImages.forEach(img => {

        img.addEventListener('click', function() {

            lightboxImg.src = this.src;

            modal.classList.add('active');

        });

    });


    // 5. Tutup modal saat tombol X diklik

    closeBtn.addEventListener('click', () => {

        modal.classList.remove('active');

    });


    // 6. Tutup modal jika area gelap di luar gambar diklik

    modal.addEventListener('click', (e) => {

        if (e.target === modal) {

            modal.classList.remove('active');

        }

    });


    // 7. Tutup modal menggunakan tombol ESC

    document.addEventListener('keydown', (e) => {

        if (e.key === 'Escape') {

            modal.classList.remove('active');

        }

    });

});