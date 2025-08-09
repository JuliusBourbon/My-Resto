document.addEventListener('DOMContentLoaded', function () {
    // --- ELEMEN DOM ---
    const orderDetailContainer = document.getElementById('order-detail-container');
    const orderDetailPlaceholder = document.getElementById('order-detail-placeholder');
    const paymentModal = document.getElementById('payment-modal');
    const customModal = document.getElementById('customModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    let modalConfirmBtn = document.getElementById('modalConfirmBtn'); // Pakai let
    const modalCancelBtn = document.getElementById('modalCancelBtn');
    const searchInput = document.getElementById('searchInput');
    const orderGrid = document.getElementById('order-grid');

    // --- STATE ---
    let currentOrderData = null;
    let activeCard = null;

    // --- FUNGSI BANTUAN ---
    const rupiah = (value) => `Rp${new Intl.NumberFormat('id-ID').format(value)}`;
    const escapeHTML = (str) => {
        const p = document.createElement('p');
        p.textContent = str;
        return p.innerHTML;
    };

    function showModal(title, message, type = 'alert', onConfirm = null) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;

        const newConfirmBtn = modalConfirmBtn.cloneNode(true);
        modalConfirmBtn.parentNode.replaceChild(newConfirmBtn, modalConfirmBtn);
        modalConfirmBtn = newConfirmBtn;
        
        if (type === 'confirm') {
            modalConfirmBtn.textContent = 'Ya, Lanjutkan';
            modalCancelBtn.style.display = 'inline-block';
            modalConfirmBtn.style.display = 'inline-block';
            modalConfirmBtn.onclick = () => {
                if (onConfirm) onConfirm();
                customModal.classList.add('hidden');
            };
            modalCancelBtn.onclick = () => customModal.classList.add('hidden');
        } else {
            modalConfirmBtn.textContent = 'OK';
            modalCancelBtn.style.display = 'none';
            modalConfirmBtn.style.display = 'inline-block';
            modalConfirmBtn.onclick = () => {
                if (onConfirm) onConfirm();
                customModal.classList.add('hidden');
            };
        }
        customModal.classList.remove('hidden');
        customModal.classList.add('flex');
    }

    function updateDetailColumn(data) {
        orderDetailPlaceholder.classList.add('hidden');
        const detailHTML = `
            <h2 class="text-xl font-bold text-gray-800 text-center mb-2">Detail Order</h2>
            <span class="text-md font-medium text-gray-600 text-center mb-4">Order ${data.info.id_pesanan} - Meja ${currentOrderData.info.nomor_meja_formatted}</span>
            <h1 class="text-center text-xl font-semibold">${data.info.nama_pelanggan}</h1>
            <div id="order-list" class="flex-grow overflow-y-auto py-4 space-y-4 pr-2">
                ${data.items.map((item, index) => {
                    const subtotal = item.qty * item.harga;
                    return `
                        <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 shadow-sm">
                            <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm">${index + 1}</div>
                            <div class="flex-grow">
                                <p class="font-semibold text-gray-800">${escapeHTML(item.nama_menu)} <span class="text-gray-500 font-medium text-sm">x${item.qty}</span></p>
                                <p class="text-sm text-gray-700 font-bold">${rupiah(subtotal)}</p>
                            </div>
                        </div>`;
                }).join('')}
            </div>
            <div class="mt-auto pt-4 border-t border-gray-200">
                <button id="payment-button" class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition-colors shadow-md">Lanjut Pembayaran</button>
            </div>`;
        orderDetailContainer.innerHTML = detailHTML;
        orderDetailContainer.classList.remove('hidden');
        orderDetailContainer.classList.add('flex');
        
        // Tambahkan event listener ke tombol 'Lanjut Pembayaran' yang baru dibuat
        document.getElementById('payment-button').addEventListener('click', openPaymentModal);
    }
    
    function openPaymentModal() {
        if (!currentOrderData) return showModal('Perhatian', 'Pilih order terlebih dahulu!');
        
        let subtotal = currentOrderData.items.reduce((acc, item) => acc + (item.qty * item.harga), 0);
        let pajak = subtotal * 0.12;
        let total = subtotal + pajak;

        const paymentModalHTML = `
            <div class="bg-white rounded-lg shadow-xl p-8 w-[600px] h-auto flex flex-col">
                <h2 class="text-xl font-bold text-gray-800 text-center mb-6">
                    Meja ${currentOrderData.info.nomor_meja_formatted} - ${currentOrderData.info.nama_pelanggan}
                </h2>
                <div class="flex-grow flex gap-6">
                    <div class="w-1/2 overflow-y-auto py-4 space-y-4 pr-2 border-r border-gray-200">${document.getElementById('order-list').innerHTML}</div>
                    <div class="w-1/2 flex flex-col justify-start space-y-4 pl-6 py-4">
                        <div class="mb-4">
                            <h3 class="font-bold text-lg mb-2">Metode Pembayaran</h3>
                            <div class="space-y-2">
                                ${['Tunai', 'Kartu', 'QRIS'].map(method => `
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="radio" name="metode" value="${method}" class="w-4 h-4"><span>${method}</span>
                                    </label>
                                `).join('')}
                            </div>
                        </div>
                        <div class="flex justify-between font-medium text-lg border-t pt-4"><span>Subtotal</span><span>${rupiah(subtotal)}</span></div>
                        <div class="flex justify-between font-medium text-lg"><span>Pajak (12%)</span><span>${rupiah(pajak)}</span></div>
                        <div class="flex justify-between font-bold text-xl"><span>Total</span><span>${rupiah(total)}</span></div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button id="close-modal-button" class="px-6 py-2 bg-[#FEE2E2] text-[#DC2626] font-semibold rounded-lg hover:bg-[#FECACA]">Kembali</button>
                    <button id="confirm" class="px-6 py-2 bg-[#D1FAE5] text-[#059669] font-semibold rounded-lg hover:bg-[#A7F3D0]">Konfirmasi</button>
                </div>
            </div>`;
        paymentModal.innerHTML = paymentModalHTML;
        paymentModal.classList.remove('hidden');
        paymentModal.classList.add('flex');

        // Tambahkan event listener untuk tombol di dalam modal pembayaran
        document.getElementById('close-modal-button').addEventListener('click', () => paymentModal.classList.add('hidden'));
        document.getElementById('confirm').addEventListener('click', confirmPayment);
    }
    
    function confirmPayment() {
        const selectedMetode = document.querySelector('#payment-modal input[name="metode"]:checked');
        if (!selectedMetode) return showModal('Perhatian', 'Silakan pilih metode pembayaran.');

        const metodePembayaran = selectedMetode.value;
        const orderId = currentOrderData.info.id_pesanan;

        showModal('Konfirmasi', `Anda yakin ingin mengonfirmasi pembayaran untuk Order ${orderId}?`, 'confirm', () => {
            fetch(`${BASE_URL}/src/pembayaranDb.php?action=confirm_payment`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_pesanan: orderId, metode: metodePembayaran })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showModal('Sukses', 'Pembayaran berhasil dikonfirmasi!', 'alert', () => window.location.reload());
                } else {
                    showModal('Gagal', 'Gagal mengonfirmasi pembayaran: ' + (data.message || 'Error'));
                }
            })
            .catch(error => showModal('Error', 'Terjadi kesalahan koneksi.'));
        });
    }

    // --- EVENT BINDING AWAL ---
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        orderGrid.querySelectorAll('.order-card').forEach(card => {
            const cardTitle = card.querySelector('h3').textContent.toLowerCase();
            card.style.display = cardTitle.includes(searchTerm) ? 'flex' : 'none';
        });
    });

    document.querySelectorAll('.detail-button').forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.dataset.orderId;
            if (activeCard) activeCard.classList.remove('ring-2', 'ring-blue-500');
            activeCard = this.closest('.order-card');
            activeCard.classList.add('ring-2', 'ring-blue-500');

            fetch(`${BASE_URL}/src/pembayaranDb.php?action=get_order_detail&id=${orderId}`)
                .then(res => res.json())
                .then(data => {
                    currentOrderData = data;
                    updateDetailColumn(data);
                })
                .catch(err => showModal('Error', "Gagal mengambil data pesanan."));
        });
    });
});