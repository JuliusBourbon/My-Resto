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
});