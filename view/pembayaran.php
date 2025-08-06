<?php
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../src/pembayaranDb.php';

    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $orders = getUnpaidOrders();    
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - List Pesanan</title>
    <link href="<?= $base_url ?>/output.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 pt-[118px]">

    <div class="flex flex-col min-h-screen">
        <!-- ====== Navbar Atas ====== -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200">
            <div class="relative flex items-center justify-center px-10 py-4">
                <div class="absolute left-10 top-1/2 -translate-y-1/2">
                    <div class="w-18 h-18">
                        <img src="<?= $base_url ?>/img/myresto_icon.jpg" alt="Logo" class="w-full h-full object-contain">
                    </div>
                </div>
                <span class="text-2xl font-bold">MyResto</span>
                <div class="absolute right-10 top-1/2 -translate-y-1/2">
                    <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center text-white cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                </div>
            </div>
            <div class="px-10 flex gap-10">
                <a href="<?= $base_url ?>/pembayaran"
                    class="py-2 font-semibold transition <?= $currentPath === '/My-Resto/pembayaran' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
                    Pembayaran
                </a>
            </div>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-grow flex p-6 gap-6">

    <!-- Sidebar Kiri: List Pesanan -->
        <div class="w-[65%] flex flex-col gap-6">
            <!-- Search Bar -->
            <div class="relative">
                <i data-feather="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                <input type="text" placeholder="Search"
                    class="w-full bg-white pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Grid Pesanan -->
            <div id="order-grid" class="grid grid-cols-4 gap-5 overflow-y-auto pr-2">
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-card bg-white p-4 rounded-lg flex flex-col justify-between shadow-sm border border-gray-200 h-36"
                            data-order-id="<?= $order['id_pesanan'] ?>">
                            <div class="text-center">
                                <h3 class="font-bold text-gray-800">
                                    Order <?= $order['id_pesanan'] ?> - Meja <?= htmlspecialchars($order['nama_pelanggan']) ?>
                                </h3>
                            </div>
                            <div class="mt-auto">
                                <button class="detail-button w-full bg-[#D9F3E4] text-gray-800 font-semibold py-2 rounded-lg hover:bg-[#c8e6d5] transition-colors"
                                        data-order-id="<?= $order['id_pesanan'] ?>">
                                    Detail
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="col-span-4 text-center text-gray-500 mt-10">Tidak ada pesanan yang perlu dibayar saat ini.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar Kanan: Detail Pesanan -->
        <div class="w-[35%] flex justify-center items-start pt-10">
            <!-- Kontainer Detail -->
            <div id="order-detail-container"
                class="bg-white rounded-xl shadow-lg p-6 flex-col w-full max-w-sm hidden"
                style="max-height: 70vh;">
                <h2 class="text-xl font-bold text-gray-800 text-center mb-2">Detail Order</h2>
                <span id="customer-name" class="text-md font-medium text-gray-600 text-center mb-4"></span>

                <div id="order-list" class="flex-grow overflow-y-auto py-4 space-y-4 pr-2"></div>

                <div class="mt-auto pt-4 border-t border-gray-200">
                    <button id="payment-button"
                            class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition-colors shadow-md">
                        Lanjut Pembayaran
                    </button>
                </div>
            </div>

            <!-- Placeholder Jika Belum Dipilih -->
            <div id="order-detail-placeholder" class="text-center text-gray-400 mt-20">
                <p>Pilih pesanan untuk melihat detail.</p>
            </div>
        </div>
    </main>

    <!-- Modal Pembayaran -->
    <div id="payment-modal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-8 w-[600px] h-auto flex flex-col">

            <h2 class="text-xl font-bold text-gray-800 text-center mb-6">Order 1 - Nama</h2>

            <div class="flex-grow flex gap-6">
                <!-- Daftar Item -->
                <div id="modal-order-list"
                    class="w-1/2 overflow-y-auto py-4 space-y-4 pr-2 border-r border-gray-200">
                </div>

                <!-- Rincian Pembayaran -->
                <div class="w-1/2 flex flex-col justify-start space-y-4 pl-6 py-4">
                    <!-- Metode Pembayaran -->
                    <div class="mb-4">
                        <h3 class="font-bold text-lg mb-2">Metode Pembayaran</h3>
                        <div class="space-y-2" id="payment-method-options">
                            <?php foreach (['Tunai', 'Kartu', 'QRIS'] as $method): ?>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="metode" value="<?= $method ?>" class="w-4 h-4">
                                    <span><?= $method ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Rincian Harga -->
                    <div class="flex justify-between font-medium text-lg border-t pt-4">
                        <span>Subtotal</span>
                        <span id="modal-subtotal">Rp0</span>
                    </div>
                    <div class="flex justify-between font-medium text-lg">
                        <span>Pajak (12%)</span>
                        <span id="modal-pajak">Rp0</span>
                    </div>
                    <div class="flex justify-between font-bold text-xl">
                        <span>Total</span>
                        <span id="modal-total">Rp0</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Modal -->
            <div class="mt-8 flex justify-end gap-4">
                <button id="close-modal-button"
                        class="px-6 py-2 bg-[#FEE2E2] text-[#DC2626] font-semibold rounded-lg hover:bg-[#FECACA]">
                    Kembali
                </button>
                <button id="confirm"
                        class="px-6 py-2 bg-[#D1FAE5] text-[#059669] font-semibold rounded-lg hover:bg-[#A7F3D0]">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>


<script>
    const baseUrl = "<?= $base_url ?>";
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const orderDetailContainer = document.getElementById('order-detail-container');
    const orderDetailPlaceholder = document.getElementById('order-detail-placeholder');
    const customerNameEl = document.getElementById('customer-name');
    const orderListEl = document.getElementById('order-list');

    const paymentButton = document.getElementById('payment-button');
    const paymentModal = document.getElementById('payment-modal');
    const closeModalButton = document.getElementById('close-modal-button');
    const confirmPaymentButton = document.getElementById('confirm');

    let currentOrderData = null;
    let activeCard = null;

    const rupiah = (value) => `Rp${new Intl.NumberFormat('id-ID').format(value)}`;
    const escapeHTML = (str) => {
        const p = document.createElement('p');
        p.appendChild(document.createTextNode(str));
        return p.innerHTML;
    };

    function updateDetailColumn(data) {
        orderDetailPlaceholder.classList.add('hidden');
        orderDetailContainer.classList.remove('hidden');
        orderDetailContainer.classList.add('flex');

        customerNameEl.textContent = `Order ${data.info.id_pesanan} - Meja ${data.info.nama_pelanggan}`;
        orderListEl.innerHTML = '';

        data.items.forEach((item, index) => {
            const subtotal = item.qty * item.harga;
            const itemHTML = `
                <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 shadow-sm">
                    <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm">${index + 1}</div>
                    <div class="flex-grow">
                        <p class="font-semibold text-gray-800">
                            ${escapeHTML(item.nama_menu)} <span class="text-gray-500 font-medium text-sm">x${item.qty}</span>
                        </p>
                        <p class="text-sm text-gray-700 font-bold">${rupiah(subtotal)}</p>
                    </div>
                </div>
            `;
            orderListEl.insertAdjacentHTML('beforeend', itemHTML);
        });
    }

    function openModalWithData() {
        const modalTitle = paymentModal.querySelector('h2');
        const modalOrderList = document.getElementById('modal-order-list');
        const modalSubtotalEl = document.getElementById('modal-subtotal');
        const modalPajakEl = document.getElementById('modal-pajak');
        const modalTotalEl = document.getElementById('modal-total');

        modalTitle.textContent = `Order ${currentOrderData.info.id_pesanan} - Meja ${currentOrderData.info.nama_pelanggan}`;
        modalOrderList.innerHTML = orderListEl.innerHTML;

        let subtotal = currentOrderData.items.reduce((acc, item) => acc + item.qty * item.harga, 0);
        let pajak = subtotal * 0.12;
        let total = subtotal + pajak;

        modalSubtotalEl.textContent = rupiah(subtotal);
        modalPajakEl.textContent = rupiah(pajak);
        modalTotalEl.textContent = rupiah(total);

        paymentModal.classList.remove('hidden');
        paymentModal.classList.add('flex');
    }

    // === Event Binding ===
    document.querySelectorAll('.detail-button').forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.dataset.orderId;

            if (activeCard) {
                activeCard.classList.remove('ring-2', 'ring-blue-500');
            }

            activeCard = this.closest('.order-card');
            activeCard.classList.add('ring-2', 'ring-blue-500');

            fetch(`${baseUrl}/src/pembayaranDb.php?action=get_order_detail&id=${orderId}`)
                .then(res => res.json())
                .then(data => {
                    currentOrderData = data;
                    updateDetailColumn(data);
                })
                .catch(err => alert("Gagal mengambil data pesanan."));
        });
    });

    paymentButton.addEventListener('click', function () {
        if (!currentOrderData) {
            alert('Pilih order terlebih dahulu!');
            return;
        }
        openModalWithData();
    });

    confirmPaymentButton.addEventListener('click', function () {
        if (!currentOrderData) return;

        const selectedMetode = document.querySelector('input[name="metode"]:checked');
        if (!selectedMetode) {
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
            return;
        }

        const metodePembayaran = selectedMetode.value;
        const orderId = currentOrderData.info.id_pesanan;

        if (!confirm(`Konfirmasi pembayaran untuk Order ${orderId} dengan metode ${metodePembayaran}?`)) {
            return;
        }

        fetch(`${baseUrl}/src/pembayaranDb.php?action=confirm_payment`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_pesanan: orderId, metode: metodePembayaran })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Pembayaran berhasil dikonfirmasi!');
                activeCard?.remove();

                orderDetailContainer.classList.add('hidden');
                orderDetailContainer.classList.remove('flex');
                orderDetailPlaceholder.classList.remove('hidden');

                paymentModal.classList.add('hidden');
                paymentModal.classList.remove('flex');

                currentOrderData = null;
                activeCard = null;
            } else {
                alert('Gagal mengonfirmasi pembayaran: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi.');
        });
    });

    closeModalButton.addEventListener('click', function () {
        paymentModal.classList.add('hidden');
        paymentModal.classList.remove('flex');
    });
});
</script>
</body>
</html>
