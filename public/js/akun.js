document.addEventListener("DOMContentLoaded",function(){

    // FILTER DAFTAR AKUN
    const searchAkun=document.getElementById('searchAkun');
    const filterRole=document.getElementById('filterRole');
    const filterStatus=document.getElementById('filterStatusAkun');
    const akunTable=document.getElementById('akunTable');
    const emptyAkun=document.getElementById('emptyAkun');

    if(akunTable){
        const tableRows=akunTable.querySelectorAll('tbody tr');

        function filterAkunTable(){
            const searchTerm=searchAkun?searchAkun.value.toLowerCase().trim():'';
            const roleTerm=filterRole?filterRole.value:'Semua';
            const statusTerm=filterStatus?filterStatus.value:'Semua';
            let visibleCount=0;

            tableRows.forEach(row=>{
                const nama=row.querySelector('.col-nama')?row.querySelector('.col-nama').textContent.toLowerCase().trim():'';
                const email=row.querySelector('.col-email')?row.querySelector('.col-email').textContent.toLowerCase().trim():'';
                const role=row.querySelector('.col-role')?row.querySelector('.col-role').dataset.role:'';
                const status=row.querySelector('.col-status')?row.querySelector('.col-status').dataset.status:'';

                const matchSearch=nama.includes(searchTerm)||email.includes(searchTerm);
                const matchRole=roleTerm==='Semua'||role===roleTerm;
                const matchStatus=statusTerm==='Semua'||status===statusTerm;

                if(matchSearch&&matchRole&&matchStatus){
                    row.style.display='';
                    visibleCount++;
                }else{
                    row.style.display='none';
                }
            });

            if(emptyAkun){
                emptyAkun.style.display=visibleCount===0?'block':'none';
            }
        }

        if(searchAkun)searchAkun.addEventListener('keyup',filterAkunTable);
        if(filterRole)filterRole.addEventListener('change',filterAkunTable);
        if(filterStatus)filterStatus.addEventListener('change',filterAkunTable);
    }

    // FORM TAMBAH AKUN
    const roleSelect=document.getElementById('role');
    const jurusanContainer=document.getElementById('jurusanContainer');
    const jurusanSelect=document.getElementById('id_jurusan');
    const helpText=document.getElementById('helpTextJurusan');

    if(roleSelect){
        function updateJurusan(){
            if(roleSelect.value==='admin_tefa'){
                if(jurusanContainer)jurusanContainer.style.display='none';
                if(jurusanSelect){
                    jurusanSelect.required=false;
                    jurusanSelect.value='';
                }
                if(helpText)helpText.textContent='Admin TEFA tidak terikat pada jurusan tertentu.';
            }else if(roleSelect.value==='admin_jurusan'){
                if(jurusanContainer)jurusanContainer.style.display='block';
                if(jurusanSelect)jurusanSelect.required=true;
                if(helpText)helpText.textContent='Pilih jurusan yang menjadi tanggung jawab akun ini.';
            }else{
                if(jurusanContainer)jurusanContainer.style.display='none';
                if(jurusanSelect)jurusanSelect.required=false;
                if(helpText)helpText.textContent='Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.';
            }
        }

        roleSelect.addEventListener('change',updateJurusan);
        updateJurusan();
    }
});