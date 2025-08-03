<?php

$currentPage = basename($_SERVER['PHP_SELF']);
// -- Data Statis untuk Frontend --

// 1. Data Order (Statis)
$orders = [
    ['id_order' => 1, 'nama_pelanggan' => 'Budi'],
    ['id_order' => 2, 'nama_pelanggan' => 'Asep'],
    ['id_order' => 3, 'nama_pelanggan' => 'Nurul'],
    ['id_order' => 4, 'nama_pelanggan' => 'Rizky'],
    ['id_order' => 5, 'nama_pelanggan' => 'Maruzensky'],
    ['id_order' => 6, 'nama_pelanggan' => 'Golshi'],
    ['id_order' => 7, 'nama_pelanggan' => 'Mejiro'],
    ['id_order' => 8, 'nama_pelanggan' => 'Bagas'],
    ['id_order' => 9, 'nama_pelanggan' => 'Indah'],
    ['id_order' => 10, 'nama_pelanggan' => 'Fajar'],
    ['id_order' => 11, 'nama_pelanggan' => 'Agus'],
    ['id_order' => 12, 'nama_pelanggan' => 'Lina'],
];

// 2. Detail Item per Order (Statis)
$order_details = [
    1 => [
        ['nama_menu' => 'Americano', 'harga' => 18000, 'qty' => 2],
        ['nama_menu' => 'Ikan dan Kentang', 'harga' => 30000, 'qty' => 1],
        ['nama_menu' => 'Garam dan Madu', 'harga' => 17000, 'qty' => 2],
        ['nama_menu' => 'Jeruk Hangat', 'harga' => 13000, 'qty' => 2],
    ]
];

// Menghitung total untuk modal
$subtotal = 0;
if (isset($order_details[1])) {
    foreach ($order_details[1] as $item) {
        $subtotal += $item['harga'] * $item['qty'];
    }
}
$pajak = $subtotal * 0.12;
$total = $subtotal + $pajak;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - List Pesanan</title>
    <link href="../output.css" rel="stylesheet">
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
                        <img src="../img/myresto_icon.jpg" alt="Logo" class="w-full h-full object-contain">
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
                <div class="flex items-center gap-6 pt-1">
                    <a href="kasirOrder.php" class="py-2 font-semibold transition <?= $currentPage === 'kasirOrder.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">Pesanan</a>
                </div>
            </div>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-grow flex p-6 gap-6">
            <!-- Kolom Kiri: List Pesanan -->
            <div class="w-[65%] flex flex-col gap-6">
                <div class="relative">
                    <i data-feather="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                    <input type="text" placeholder="Search" class="w-full bg-white pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="grid grid-cols-4 gap-5 overflow-y-auto pr-2">
                    <?php foreach ($orders as $order): ?>
                        <div class="bg-white p-4 rounded-lg flex flex-col justify-between shadow-sm border border-gray-200 h-36">
                            <div class="text-center">
                                <h3 class="font-bold text-gray-800">Order <?php echo $order['id_order']; ?> - <?php echo htmlspecialchars($order['nama_pelanggan']); ?></h3>
                            </div>
                            <div class="mt-auto">
                                <button class="w-full bg-[#D9F3E4] text-gray-800 font-semibold py-2 rounded-lg hover:bg-[#c8e6d5] transition-colors">Detail</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Kolom Kanan: Detail Order -->
            <div class="w-[35%] flex justify-center items-start pt-10">
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col w-full max-w-sm" style="max-height: 70vh;">
                    <h2 class="text-xl font-bold text-gray-800 text-center mb-2">Detail Order</h2>
                    <span id="customer-name" class="text-md font-medium text-gray-600 text-center mb-4">Order 1 - Budi</span>
                    <div id="order-list" class="flex-grow overflow-y-auto py-4 space-y-4 pr-2">
                        <?php if(isset($order_details[1])): ?>
                            <?php foreach($order_details[1] as $index => $item): ?>
                                <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 shadow-sm">
                                    <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm"><?php echo $index + 1; ?></div>
                                    <div class="flex-grow">
                                        <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($item['nama_menu']); ?> <span class="text-gray-500 font-medium text-sm">x<?php echo $item['qty']; ?></span></p>
                                        <p class="text-sm text-gray-700 font-bold">Rp<?php echo number_format($item['harga'] * $item['qty'], 0, ',', '.'); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="mt-auto pt-4 border-t border-gray-200">
                        <button id="payment-button" class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition-colors shadow-md">Lanjut Pembayaran</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-8 w-[600px] h-auto flex flex-col">
            <h2 class="text-xl font-bold text-gray-800 text-center mb-6">Order 1 - Budi</h2>
            <div class="flex-grow flex gap-6">
                <!-- Kolom Kiri Modal -->
                <div id="modal-order-list" class="w-1/2 flex-grow overflow-y-auto py-4 space-y-4 pr-2 border-r border-gray-200">
                    <!-- Konten list order akan disalin ke sini oleh JS -->
                </div>
                <!-- Kolom Kanan Modal -->
                <div class="w-1/2 flex flex-col justify-start space-y-4 pl-6 py-4">
                    <div class="flex justify-between font-medium text-lg">
                        <span>Subtotal</span>
                        <span id="modal-subtotal">Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                    </div>
                    <div class="flex justify-between font-medium text-lg">
                        <span>Pajak (12%)</span>
                        <span id="modal-pajak">Rp<?php echo number_format($pajak, 0, ',', '.'); ?></span>
                    </div>
                    <div class="flex justify-between font-bold text-xl">
                        <span>Total</span>
                        <span id="modal-total">Rp<?php echo number_format($total, 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-4">
                <button id="close-modal-button" class="px-6 py-2 bg-[#FEE2E2] text-[#DC2626] font-semibold rounded-lg hover:bg-[#FECACA]">Kembali</button>
                <button class="px-6 py-2 bg-[#D1FAE5] text-[#059669] font-semibold rounded-lg hover:bg-[#A7F3D0]">Konfirmasi</button>
            </div>
        </div>
    </div>


    <script>
        feather.replace();

        document.addEventListener('DOMContentLoaded', function () {
            const paymentButton = document.getElementById('payment-button');
            const paymentModal = document.getElementById('payment-modal');
            const closeModalButton = document.getElementById('close-modal-button');
            const orderList = document.getElementById('order-list');
            const modalOrderList = document.getElementById('modal-order-list');

            paymentButton.addEventListener('click', function() {
                // Salin konten list order ke modal
                modalOrderList.innerHTML = orderList.innerHTML;
                // Tampilkan modal
                paymentModal.classList.remove('hidden');
                paymentModal.classList.add('flex');
            });

            const closeModal = function() {
                paymentModal.classList.add('hidden');
                paymentModal.classList.remove('flex');
            }

            closeModalButton.addEventListener('click', closeModal);

            // Tutup modal jika klik di luar area konten
            paymentModal.addEventListener('click', function(event) {
                if (event.target === paymentModal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>
