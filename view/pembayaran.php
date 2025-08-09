<?php
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../src/pembayaranDb.php';
    require_once __DIR__ . '/../src/middleware.php';
    requireRole('kasir');
    $nama = $_SESSION['nama'] ?? $_SESSION['email'] ?? 'User';
    $role = $_SESSION['role'] ?? '-';
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
                        <img src="<?= $base_url ?>/img/myresto_icon.jpg" alt="Logo" class="w-full h-full object-contain" />
                    </div>
                    </div>
                    <span class="text-2xl font-bold">MyResto</span>
                    <div class="absolute right-10 top-1/2 -translate-y-1/2">
                    <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center text-white cursor-pointer">
                        <div class="absolute right-10 top-1/2 -translate-y-1/2 flex items-center gap-4">
                        <form action="<?= $base_url ?>/logout" method="POST">
                            <button type="submit" class="ml-2 mr-2 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition text-sm">
                            Logout
                            </button>
                        </form>
                        <div class="text-right text-sm mr-4">
                            <div class="font-semibold text-gray-700"><?= htmlspecialchars($nama) ?></div>
                            <div class="text-gray-500 capitalize"><?= htmlspecialchars($role) ?></div>
                        </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="px-10 flex gap-10">
                <a href="<?= $base_url ?>/pembayaran"
                    class="flex gap-3 py-2 font-semibold transition <?= $currentPath === '/My-Resto/pembayaran' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>

                    Pembayaran
                </a>
                <a href="<?= $base_url ?>/histori"
                    class="flex gap-3 py-2 font-semibold transition <?= $currentPath === '/My-Resto/histori' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history-icon lucide-history"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>
                    Histori
                </a>
            </div>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-grow flex p-6 gap-6">
            <div class="w-[65%] flex flex-col gap-6">
                <!-- Search Bar -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    
                    <input type="text" id="searchInput" placeholder="Cari Pesanan" class="w-full bg-white pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Grid Pesanan -->
                <div id="order-grid" class="grid grid-cols-4 gap-5 overflow-y-auto pr-2 h-2/9">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="order-card bg-white p-4 rounded-lg flex flex-col justify-between shadow-sm border border-gray-200"
                                data-order-id="<?= $order['id_pesanan'] ?>">
                                <div class="text-center flex flex-col m-5">
                                    <h3 class="font-bold text-xl text-gray-800">
                                        Order <?= $order['id_pesanan'] ?> - Meja <?= htmlspecialchars($order['nomor_meja']) ?>
                                    </h3>
                                    <h1 class="text-xl font-semibold"><?= htmlspecialchars($order['nama_pelanggan']) ?></h1>
                                </div>
                                <div class="">
                                    <button class="detail-button w-full text-lg bg-[#D9F3E4] text-gray-800 font-semibold py-2 rounded-lg hover:bg-[#c8e6d5] transition-colors"
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

        <div id="payment-modal"
            class="fixed inset-0 bg-opacity-50 hidden items-center justify-center z-50">
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

        <div id="customModal" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-51">
            <div class="bg-white rounded-lg shadow-xl p-8 w-[600px] h-auto flex flex-col">
                <h2 id="modalTitle" class="text-2xl font-bold mb-4 text-center">Judul Modal</h2>
                <p id="modalMessage" class="text-center text-gray-600 mb-6">Pesan modal.</p>
                
                <div id="modal-buttons" class="flex justify-end gap-4">
                    <button id="modalCancelBtn" class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">Batal</button>
                    <button id="modalConfirmBtn" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">OK</button>
                </div>
            </div>
        </div>
    </div>
    


  <script>
    const BASE_URL = "<?= $base_url ?>";
  </script>
  <script src="<?= $base_url ?>/script/pembayaran.js"></script>
</body>
</html>
