// Logika untuk menampilkan/menyembunyikan Navigation Drawer
function toggleDrawer() {
    const navDrawer = document.getElementById('navDrawer');
    const overlay = document.getElementById('overlay');
    
    // Pastikan elemennya ada sebelum dijalankan
    if(navDrawer && overlay) {
        navDrawer.classList.toggle('open');
        overlay.classList.toggle('active');
    }
}

// Logika untuk Perlihatkan Password di halaman Login
document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // Jika elemen togglePassword ditemukan di halaman tersebut
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('change', function() {
            if(this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    }
});