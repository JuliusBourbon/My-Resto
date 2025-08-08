document.getElementById('Reservasi').addEventListener('click', function () {
    document.getElementById('reservasiModal').classList.remove('hidden');
    document.getElementById('main').classList.add('blur-sm');
});

window.addEventListener('click', function (event) {
    const modal = document.getElementById('reservasiModal');
    if (event.target === modal) {
    modal.classList.add('hidden');
    main.classList.remove('blur-sm');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const jumlahButtons = document.querySelectorAll('.btn-jumlah');
    const hiddenJumlahInput = document.getElementById('jumlahValue');
    const mejaSelect = document.getElementById('id_meja');
    const judulJumlah = document.getElementById('judul-jumlah');
    const containerJumlah = document.getElementById('container-jumlah');

    // Tambahkan class untuk style tombol aktif
    const activeClass = 'bg-blue-500 text-white';
    const inactiveClass = 'bg-gray-300';
    
    // Beri tombol pertama style aktif sebagai default
    if (jumlahButtons.length > 0) {
        jumlahButtons[0].classList.add(...activeClass.split(' '));
        jumlahButtons[0].classList.remove(...inactiveClass.split(' '));
    }

    // Event listener untuk tombol preset (1, 2, 3)
    jumlahButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update nilai input tersembunyi
            hiddenJumlahInput.value = this.value;

            // Atur style tombol aktif
            jumlahButtons.forEach(btn => {
                btn.classList.remove(...activeClass.split(' '));
                btn.classList.add(...inactiveClass.split(' '));
            });
            this.classList.add(...activeClass.split(' '));
            this.classList.remove(...inactiveClass.split(' '));
        });
    });

    if (mejaSelect && judulJumlah && containerJumlah && hiddenJumlahInput) {
        
        mejaSelect.addEventListener('change', function() {
            // Ambil option yang sedang dipilih
            const selectedOption = this.options[this.selectedIndex];
            
            // Cek apakah option punya atribut data-nomor
            if (selectedOption.dataset.nomor) {
                const nomorMeja = parseInt(selectedOption.dataset.nomor, 10);

                // Jika nomor meja antara 11 dan 18
                if (nomorMeja >= 11 && nomorMeja <= 18) {
                    // Sembunyikan elemen
                    judulJumlah.classList.add('hidden');
                    containerJumlah.classList.add('hidden');
                    // Atur jumlah pelanggan ke 1 secara otomatis
                    hiddenJumlahInput.value = '1'; 
                } else {
                    // Tampilkan kembali elemen
                    judulJumlah.classList.remove('hidden');
                    containerJumlah.classList.remove('hidden');
                }
            } else {
                // Jika yang dipilih adalah "-- Pilih Meja --", tampilkan kembali
                 judulJumlah.classList.remove('hidden');
                 containerJumlah.classList.remove('hidden');
            }
        });
    }
});