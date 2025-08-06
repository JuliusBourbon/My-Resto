document.addEventListener('DOMContentLoaded', () => {
    
    // --- Seleksi Semua Elemen DOM yang Dibutuhkan ---
    
    // Elemen untuk Tab
    const pendingTab = document.getElementById('pendingTab');
    const confirmedTab = document.getElementById('confirmedTab');
    const pendingSection = document.getElementById('pendingSection');
    const confirmedSection = document.getElementById('confirmedSection');

    // Elemen untuk Modal Detail Pesanan
    const modalDetail = document.getElementById('reservasiModal');
    const menuList = document.getElementById('menuList');
    
    // Elemen untuk Modal Pembatalan dengan Catatan
    const cancelModal = document.getElementById('cancelModal');
    const cancelModalTitle = document.getElementById('cancelModalTitle');
    const cancelOrderIdInput = document.getElementById('cancelOrderIdInput');
    const cancelNoteInput = document.getElementById('cancelNoteInput');
    
    // Elemen untuk Modal Konfirmasi Umum
    const confirmationModal = document.getElementById('confirmationModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalConfirmBtn = document.getElementById('modalConfirmBtn');
    const modalCancelBtn = document.getElementById('modalCancelBtn');

    // Variabel untuk menyimpan form yang akan di-submit dari modal konfirmasi
    let formToSubmit = null;

    // --- Logika untuk Tabs ---
    if (pendingTab && confirmedTab) {
        pendingTab.addEventListener('click', () => {
            pendingSection.classList.remove('hidden');
            confirmedSection.classList.add('hidden');
            pendingTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-blue-500 text-blue-600 bg-blue-50";
            confirmedTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-transparent text-gray-500";
        });

        confirmedTab.addEventListener('click', () => {
            confirmedSection.classList.remove('hidden');
            pendingSection.classList.add('hidden');
            confirmedTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-blue-500 text-blue-600 bg-blue-50";
            pendingTab.className = "tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-transparent text-gray-500";
        });
    }

    // --- Logika untuk Modal Konfirmasi Umum (untuk tombol '✓') ---
    document.querySelectorAll('.confirm-action-btn').forEach(button => {
        button.addEventListener('click', function() {
            const message = this.dataset.message;
            formToSubmit = this.closest('form');
            modalMessage.textContent = message;
            confirmationModal.classList.remove('hidden');
            confirmationModal.classList.add('flex');
        });
    });

    if(modalConfirmBtn) {
        modalConfirmBtn.addEventListener('click', () => {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });
    }

    if(modalCancelBtn) {
        modalCancelBtn.addEventListener('click', () => {
            confirmationModal.classList.add('hidden');
            confirmationModal.classList.remove('flex');
            formToSubmit = null;
        });
    }
    
    // --- Logika untuk Modal Pembatalan dengan Catatan (untuk tombol 'X') ---
    document.querySelectorAll('.cancel-btn').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const tableRow = this.closest('tr');
            const tableInfo = tableRow.querySelectorAll('td')[1].textContent.trim();
            const customerName = tableRow.querySelectorAll('td')[2].textContent.trim();
            
            cancelModalTitle.textContent = `Batalkan Pesanan (${tableInfo} - ${customerName})`;
            cancelOrderIdInput.value = orderId;
            cancelNoteInput.value = '';
            cancelModal.classList.remove('hidden');
            cancelModal.classList.add('flex');
        });
    });

    // --- Fungsi Global untuk dipanggil dari HTML (onclick) ---
    // Fungsi ini harus berada di 'window' agar bisa diakses dari atribut onclick di HTML
    window.tampilkanDetail = function(id_pesanan) {
        menuList.innerHTML = '';
        if (typeof detailPesananData !== 'undefined' && detailPesananData[id_pesanan]) {
            detailPesananData[id_pesanan].forEach(item => {
                const li = document.createElement('li');
                li.className = "border-b pb-2";
                li.innerHTML = `<span class="font-bold">${item.jumlah}x</span> ${item.nama_menu}`;
                menuList.appendChild(li);
            });
        } else {
            menuList.innerHTML = '<li>Tidak ada detail untuk pesanan ini.</li>';
        }
        modalDetail.classList.remove('hidden');
        modalDetail.classList.add('flex');
    }

    window.tutupModal = function() {
        modalDetail.classList.add('hidden');
        modalDetail.classList.remove('flex');
    }
    
    window.tutupCancelModal = function() {
        cancelModal.classList.add('hidden');
        cancelModal.classList.remove('flex');
    }
});