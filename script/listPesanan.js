const confirmationModal = document.getElementById('confirmationModal');
const modalTitle = document.getElementById('modalTitle');
const modalMessage = document.getElementById('modalMessage');
const modalConfirmBtn = document.getElementById('modalConfirmBtn');
const modalCancelBtn = document.getElementById('modalCancelBtn');

let formToSubmit = null; // Variabel untuk menyimpan form yang akan di-submit

// Tambahkan event listener ke semua tombol aksi
document.querySelectorAll('.confirm-action-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        // Ambil pesan dari atribut data-message
        const message = this.dataset.message;
        
        // Simpan form terdekat dari tombol yang diklik
        formToSubmit = this.closest('form');
        
        // Atur isi pesan di modal
        modalMessage.textContent = message;
        
        // Tampilkan modal
        confirmationModal.classList.remove('hidden');
        confirmationModal.classList.add('flex');
    });
});

// Event listener untuk tombol "Ya, Lanjutkan" di dalam modal
modalConfirmBtn.addEventListener('click', () => {
    if (formToSubmit) {
        formToSubmit.submit(); // Submit form yang sudah kita simpan
    }
});

// Event listener untuk tombol "Batal" di dalam modal
modalCancelBtn.addEventListener('click', () => {
    confirmationModal.classList.add('hidden');
    confirmationModal.classList.remove('flex');
    formToSubmit = null; // Reset variabel
});

const pendingTab = document.getElementById('pendingTab');
const confirmedTab = document.getElementById('confirmedTab');
const pendingSection = document.getElementById('pendingSection');
const confirmedSection = document.getElementById('confirmedSection');

pendingTab.addEventListener('click', () => {
    // Tampilkan section pending
    pendingSection.classList.remove('hidden');
    confirmedSection.classList.add('hidden');
    // Atur style tab
    pendingTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-blue-500 text-blue-600 bg-blue-50";
    confirmedTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-transparent text-gray-500";
});

confirmedTab.addEventListener('click', () => {
    // Tampilkan section terkonfirmasi
    confirmedSection.classList.remove('hidden');
    pendingSection.classList.add('hidden');
    // Atur style tab
    confirmedTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-blue-500 text-blue-600 bg-blue-50";
    pendingTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-transparent text-gray-500";
});

const modal = document.getElementById('reservasiModal');
const menuList = document.getElementById('menuList');

function tampilkanDetail(id_pesanan) {
    // Kosongkan list sebelumnya
    menuList.innerHTML = '';
    
    // Cek apakah ada data untuk id_pesanan ini
    if (detailPesananData[id_pesanan]) {
        detailPesananData[id_pesanan].forEach(item => {
            const li = document.createElement('li');
            li.className = "border-b pb-2";
            li.innerHTML = `<span class="font-bold">${item.jumlah}x</span> ${item.nama_menu}`;
            menuList.appendChild(li);
        });
    } else {
        menuList.innerHTML = '<li>Tidak ada detail untuk pesanan ini.</li>';
    }
    
    // Tampilkan modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function tutupModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}