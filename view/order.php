<?php

    $currentPage = basename($_SERVER['PHP_SELF']); // ambil nama file saat ini
// -- Data Statis untuk Frontend --

// 1. Data Kategori Menu (Statis)
$kategori_menu = [
    ['id_kategori' => 1, 'nama_kategori' => 'Sarapan', 'warna_bg_class' => 'bg-[#C8F6BC]'],
    ['id_kategori' => 2, 'nama_kategori' => 'Hidangan Utama', 'warna_bg_class' => 'bg-[#FFD27E]'],
    ['id_kategori' => 3, 'nama_kategori' => 'Minuman', 'warna_bg_class' => 'bg-[#A2F9FF]'],
    ['id_kategori' => 4, 'nama_kategori' => 'Penutup', 'warna_bg_class' => 'bg-[#FEC0FF]'],
];

// 2. Data Item Menu (Statis)
$menu_items = [
    1 => [
        ['id_menu' => 2, 'nama_menu' => 'Garam dan Madu', 'harga' => 17000, 'id_kategori' => 1],
        ['id_menu' => 5, 'nama_menu' => 'Bubur Spesial', 'harga' => 19000, 'id_kategori' => 1],
    ],
    2 => [
        ['id_menu' => 1, 'nama_menu' => 'Ikan dan Kentang', 'harga' => 30000, 'id_kategori' => 2],
        ['id_menu' => 6, 'nama_menu' => 'Nasi Goreng', 'harga' => 22000, 'id_kategori' => 2],
        ['id_menu' => 7, 'nama_menu' => 'Ayam Chicken', 'harga' => 23000, 'id_kategori' => 2],
    ],
    3 => [
        ['id_menu' => 3, 'nama_menu' => 'Jeruk Hangat', 'harga' => 13000, 'id_kategori' => 3],
        ['id_menu' => 4, 'nama_menu' => 'Americano', 'harga' => 18000, 'id_kategori' => 3],
    ],
    4 => [
        ['id_menu' => 8, 'nama_menu' => 'Cendol', 'harga' => 18000, 'id_kategori' => 4],
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Pesanan - MyResto</title>
        <link href="../output.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Menyembunyikan panah default pada input number */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
    </style>
</head>
<body class="bg-gray-50 pt-[125px]">

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
                    <a href="meja.php" class="py-2 font-semibold transition <?= $currentPage === 'meja.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">Meja</a>
                </div>
                <div class="flex items-center gap-6 pt-1">
                    <a href="order.php" class="py-2 font-semibold transition <?= $currentPage === 'order.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">Pesanan</a>
                </div>
                <div class="flex items-center gap-6 pt-1">
                    <a href="notifikasi.php" class="py-2 font-semibold transition<?= $currentPage === 'notifikasi.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">Notifikasi</a>
                </div>
            </div>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-grow flex p-6 gap-6">
            <!-- Kolom Kiri: Menu -->
            <div class="w-[65%] flex flex-col gap-6">
                <div class="relative">
                    <i data-feather="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                    <input type="text" placeholder="Search" class="w-full bg-white pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-4 gap-5">
                    <?php foreach ($kategori_menu as $kategori): ?>
                        <button class="p-4 rounded-lg text-center font-semibold text-gray-700 shadow-sm h-36 flex items-center justify-center <?php echo htmlspecialchars($kategori['warna_bg_class']); ?>">
                            <span><?php echo htmlspecialchars($kategori['nama_kategori']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <hr class="border-t border-gray-200">

                <div class="grid grid-cols-4 gap-5 overflow-y-auto pr-2">
                    <?php foreach ($menu_items as $id_kategori => $items): ?>
                        <?php
                            $bgColorClass = 'bg-gray-200';
                            foreach ($kategori_menu as $kategori) {
                                if ($kategori['id_kategori'] == $id_kategori) {
                                    $bgColorClass = $kategori['warna_bg_class'];
                                    break;
                                }
                            }
                        ?>
                        <?php foreach ($items as $item): ?>
                            <div class="menu-item p-4 rounded-lg flex flex-col justify-between shadow-sm cursor-pointer h-36 <?php echo $bgColorClass; ?>" data-id="<?php echo $item['id_menu']; ?>" data-nama="<?php echo htmlspecialchars($item['nama_menu']); ?>" data-harga="<?php echo $item['harga']; ?>">
                                <div class="flex-grow">
                                    <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($item['nama_menu']); ?></h3>
                                    <p class="text-sm text-gray-700 font-medium">Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="flex items-center justify-center gap-[10px] mt-4">
                                    <button class="quantity-btn minus bg-white rounded-md p-1 w-7 h-7 flex items-center justify-center text-lg font-bold text-gray-600 shadow">-</button>
                                    <input type="number" class="quantity font-semibold text-gray-800 text-lg bg-transparent w-10 text-center" value="0" min="0">
                                    <button class="quantity-btn plus bg-white rounded-md p-1 w-7 h-7 flex items-center justify-center text-lg font-bold text-gray-600 shadow">+</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Kolom Kanan: Order Summary -->
            <div class="w-[35%] flex justify-center items-start pt-10">
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col w-full max-w-sm" style="max-height: 70vh;">
                    <div class="relative inline-block justify-center items-center pb-4 mx-auto">
                         <button id="order-button" class="bg-gray-100 border border-gray-300 rounded-md px-4 py-2 flex items-center gap-2">
                            <span id="order-name" class="font-semibold text-gray-700">Order 1</span>
                            <i data-feather="chevron-down" class="w-4 h-4 text-gray-600"></i>
                        </button>
                        <div id="order-dropdown" class="hidden absolute top-full bg-gray-50 min-w-[160px] shadow-lg z-10 rounded-lg">
                            <a href="#" data-name="Budi" class="text-black px-4 py-3 block hover:bg-gray-100">Budi</a>
                            <a href="#" data-name="Ani" class="text-black px-4 py-3 block hover:bg-gray-100">Ani</a>
                            <a href="#" data-name="Joko" class="text-black px-4 py-3 block hover:bg-gray-100">Joko</a>
                        </div>
                    </div>
                    <span id="customer-name" class="text-lg font-bold text-gray-800 text-center mb-4">Budi</span>
                    <div id="order-list" class="flex-grow overflow-y-auto py-4 space-y-4 pr-2"></div>
                    <div class="mt-auto pt-4 border-t border-gray-200">
                        <button class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition-colors shadow-md">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        feather.replace();
        document.addEventListener('DOMContentLoaded', function () {
            const orderList = document.getElementById('order-list');
            const order = {};

            const orderButton = document.getElementById('order-button');
            const orderDropdown = document.getElementById('order-dropdown');
            const customerName = document.getElementById('customer-name');

            orderButton.addEventListener('click', function(e) {
                e.stopPropagation();
                orderDropdown.classList.toggle('hidden');
            });

            orderDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                if (e.target.tagName === 'A') {
                    const newName = e.target.dataset.name;
                    customerName.textContent = newName;
                    orderDropdown.classList.add('hidden');
                }
            });

            window.addEventListener('click', function(e) {
                if (!orderButton.contains(e.target)) {
                    orderDropdown.classList.add('hidden');
                }
            });

            function renderOrder() {
                orderList.innerHTML = '';
                let itemNumber = 1;
                for (const id in order) {
                    const item = order[id];
                    const itemTotal = item.harga * item.qty;
                    const div = document.createElement('div');
                    div.classList.add('flex', 'items-center', 'gap-3', 'p-3', 'rounded-lg', 'border', 'border-gray-200', 'shadow-sm');
                    div.innerHTML = `
                        <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm">${itemNumber++}</div>
                        <div class="flex-grow">
                            <p class="font-semibold text-gray-800">${item.nama} <span class="text-gray-500 font-medium text-sm">x${item.qty}</span></p>
                            <p class="text-sm text-gray-700 font-bold">Rp${itemTotal.toLocaleString('id-ID')}</p>
                        </div>
                        <button class="text-red-500 hover:text-red-700 remove-item" data-id="${id}">
                            <i data-feather="trash-2" class="w-5 h-5"></i>
                        </button>`;
                    orderList.appendChild(div);
                }
                feather.replace();
            }

            document.querySelectorAll('.quantity-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const menuItemDiv = this.closest('.menu-item');
                    const quantityInput = menuItemDiv.querySelector('.quantity');
                    let quantity = parseInt(quantityInput.value || '0');
                    if (this.classList.contains('plus')) {
                        quantity++;
                    } else if (this.classList.contains('minus') && quantity > 0) {
                        quantity--;
                    }
                    quantityInput.value = quantity;
                    updateOrder(menuItemDiv, quantity);
                });
            });

            document.querySelectorAll('.quantity').forEach(input => {
                input.addEventListener('focus', function(e) {
                    if (this.value === '0') {
                        this.value = '';
                    }
                });

                input.addEventListener('input', function(e) {
                    const menuItemDiv = this.closest('.menu-item');
                    let quantity = parseInt(this.value || '0');
                     if (quantity < 0) {
                        quantity = 0;
                    }
                    updateOrder(menuItemDiv, quantity);
                });

                input.addEventListener('blur', function(e) {
                    const menuItemDiv = this.closest('.menu-item');
                    if (this.value === '' || parseInt(this.value) < 0) {
                        this.value = '0';
                        updateOrder(menuItemDiv, 0);
                    }
                });
            });

            function updateOrder(menuItemDiv, quantity) {
                const id = menuItemDiv.dataset.id;
                if (quantity > 0) {
                    order[id] = { nama: menuItemDiv.dataset.nama, harga: parseFloat(menuItemDiv.dataset.harga), qty: quantity };
                } else {
                    delete order[id];
                }
                renderOrder();
            }

            orderList.addEventListener('click', function(e) {
                const removeButton = e.target.closest('.remove-item');
                if (removeButton) {
                    const id = removeButton.dataset.id;
                    delete order[id];
                    const menuItemDiv = document.querySelector(`.menu-item[data-id='${id}']`);
                    if(menuItemDiv) {
                        menuItemDiv.querySelector('.quantity').value = '0';
                    }
                    renderOrder();
                }
            });
        });
    </script>
</body>
</html>
