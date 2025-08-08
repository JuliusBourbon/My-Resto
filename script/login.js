document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen-elemen yang dibutuhkan dari DOM
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashedIcon = document.getElementById('eye-slashed-icon');

    // Pastikan semua elemen ditemukan sebelum menambahkan event listener
    if (togglePasswordButton) {
        // Tambahkan event listener untuk tombol
        togglePasswordButton.addEventListener('click', function () {
            // Cek tipe input saat ini
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon yang ditampilkan
            eyeIcon.classList.toggle('hidden');
            eyeSlashedIcon.classList.toggle('hidden');
        });
    }

    const errorPopup = document.getElementById('error-popup');
    const closePopupButton = document.getElementById('close-popup');

    // Cek jika pop-up ada di halaman
    if (errorPopup) {
        // Tampilkan pop-up
        errorPopup.style.display = 'flex';

        // Sembunyikan pop-up setelah 5 detik
        setTimeout(() => {
            errorPopup.style.opacity = '0';
            setTimeout(() => {
                if (errorPopup) errorPopup.style.display = 'none';
            }, 300); // Waktu ini harus sama dengan durasi transisi
        }, 5000);

        // Tambahkan event listener untuk tombol close
        if (closePopupButton) {
            closePopupButton.addEventListener('click', function() {
                errorPopup.style.opacity = '0';
                setTimeout(() => {
                    if (errorPopup) errorPopup.style.display = 'none';
                }, 300);
            });
        }
    }
});