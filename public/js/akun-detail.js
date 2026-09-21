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