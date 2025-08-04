<?php

    require('../src/pesananDb.php');
    $currentPage = basename($_SERVER['PHP_SELF']); // ambil nama file saat ini
    
    // -- Data Statis untuk Frontend --

// 1. Data Kategori Menu (Statis)
// $kategori_menu = [
//     ['id_kategori' => 1, 'nama_kategori' => 'Sarapan', 'warna_bg_class' => 'bg-[#C8F6BC]'],
//     ['id_kategori' => 2, 'nama_kategori' => 'Hidangan Utama', 'warna_bg_class' => 'bg-[#FFD27E]'],
//     ['id_kategori' => 3, 'nama_kategori' => 'Minuman', 'warna_bg_class' => 'bg-[#A2F9FF]'],
//     ['id_kategori' => 4, 'nama_kategori' => 'Penutup', 'warna_bg_class' => 'bg-[#FEC0FF]'],
// ];

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
                    <?php while ($row = $kategori->fetch_assoc()) :
                        $bgClass = '';

                        switch ($row['nama_kategori']) {
                            case 'Sarapan':
                                $bgClass = 'bg-[#C8F6BC]';
                                break;
                            case 'Hidangan Utama':
                                $bgClass = 'bg-[#FFD27E]';
                                break;
                            case 'Minuman':
                                $bgClass = 'bg-[#A2F9FF]';
                                break;
                            case 'Penutup':
                                $bgClass = 'bg-[#FEC0FF]';
                                break;
                            default:
                                $bgClass = 'bg-gray-200'; 
                        }
                    ?>
                        <button class="p-4 rounded-lg text-center font-semibold text-gray-700 shadow-sm h-36 flex items-center justify-center <?= $bgClass ?>">
                            <span><?= $row['nama_kategori'] ?></span>
                        </button>
                    <?php endwhile; ?>
                </div>
                
                <hr class="border-t border-gray-200">

                <div class="grid grid-cols-4 gap-5 overflow-y-auto pr-2">
                    <?php while ($item = $menu->fetch_assoc()) : 
                        $bgClass = '';
                        switch ($item['nama_kategori']) {
                            case 'Sarapan':
                                $bgClass = 'bg-[#C8F6BC]';
                                break;
                            case 'Hidangan Utama':
                                $bgClass = 'bg-[#FFD27E]';
                                break;
                            case 'Minuman':
                                $bgClass = 'bg-[#A2F9FF]';
                                break;
                            case 'Penutup':
                                $bgClass = 'bg-[#FEC0FF]';
                                break;
                            default:
                                $bgClass = 'bg-gray-200';
                        }
                    ?>
                        <div class="menu-item p-4 rounded-lg flex flex-col justify-between shadow-sm cursor-pointer h-36 <?= $bgClass ?>"
                            data-id="<?= $item['id_menu'] ?>" 
                            data-nama="<?= $item['nama'] ?>" 
                            data-harga="<?= $item['harga'] ?>">
                            
                            <div class="flex-grow">
                                <h3 class="font-bold text-gray-800"><?= $item['nama'] ?></h3>
                                <p class="text-sm text-gray-700 font-medium">Rp<?= number_format($item['harga'], 0, ',', '.') ?></p>
                            </div>

                            <div class="flex items-center justify-center gap-[10px] mt-4">
                                <button class="quantity-btn minus bg-white rounded-md p-1 w-7 h-7 flex items-center justify-center text-lg font-bold text-gray-600 shadow cursor-pointer">-</button>
                                    <input type="number" class="quantity font-semibold text-gray-800 text-lg bg-transparent w-10 text-center" value="0" min="0">
                                <button class="quantity-btn plus bg-white rounded-md p-1 w-7 h-7 flex items-center justify-center text-lg font-bold text-gray-600 shadow cursor-pointer">+</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

            </div>

            <!-- Kolom Kanan: Order Summary -->
            <div class="w-[35%] flex justify-center items-start pt-10">
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col w-full max-w-sm" style="max-height: 70vh;">
                    <form action="" method="GET" class="w-full flex flex-col">
                        <div class="relative inline-block justify-center items-center pb-4 mx-auto">
                            <label for="meja" class="block font-semibold mb-2">Pilih Meja</label>
                            <select name="meja" id="meja" class="w-full p-2 mb-4 border rounded" onchange="this.form.submit()" required>
                                <option value="">-- Pilih Meja --</option>
                                <?php
                                $counter11 = 1;
                                while ($row = $mejaReserved->fetch_assoc()) :
                                    if ($row['nomor'] == 11) {
                                        $label = '11-' . $counter11;
                                        $counter11++;
                                    } else {
                                        $label = $row['nomor'];
                                    }
                                    $selected = isset($_GET['meja']) && $_GET['meja'] == $row['nomor'] ? 'selected' : '';
                                ?>
                                    <option value="<?= $row['nomor'] ?>" <?= $selected ?>>Meja <?= $label ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <?php if ($pesananNama) : ?>
                            <span id="customer-name" class="text-lg font-bold text-gray-800 text-center mb-4">
                                Atas Nama: <?= htmlspecialchars($pesananNama) ?>
                            </span>
                        <?php endif; ?>

                        <div id="order-list" class="flex-grow overflow-y-auto py-4 space-y-4 pr-2"></div>
                        
                        <div id="order-summary" class="mt-8 border-t pt-4">
                            <h2 class="text-xl font-bold mb-2">Order Summary</h2>
                            <div id="summary-items" class="space-y-2"></div>
                        </div>
                        
                        <div class="mt-auto pt-4 border-t border-gray-200">
                            <button type="button" class="konfirmasi-btn bg-blue-700 text-white py-3 rounded-lg w-full">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ambil semua tombol plus dan minus
            const plusButtons = document.querySelectorAll(".quantity-btn.plus");
            const minusButtons = document.querySelectorAll(".quantity-btn.minus");
            const menuItems = document.querySelectorAll(".menu-item");
            const summaryContainer = document.getElementById("summary-items");

            // Event untuk tambah jumlah
            plusButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const input = this.parentElement.querySelector(".quantity");
                    input.value = parseInt(input.value) + 1;
                });
            });

            // Event untuk kurangi jumlah
            minusButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const input = this.parentElement.querySelector(".quantity");
                    const current = parseInt(input.value);
                    if (current > 0) {
                        input.value = current - 1;
                    }
                });
            });

            function updateSummary() {
                summaryContainer.innerHTML = ""; // Reset

                menuItems.forEach(item => {
                    const qtyInput = item.querySelector(".quantity");
                    const qty = parseInt(qtyInput.value);
                    if (qty < 0 || isNaN(qty)) return;
                    if (qty > 0) {
                        const name = item.dataset.nama;
                        const harga = parseInt(item.dataset.harga);
                        const total = harga * qty;

                        const summaryItem = document.createElement("div");
                        summaryItem.classList.add("flex", "justify-between", "items-center", "bg-gray-100", "p-2", "rounded");

                        summaryItem.innerHTML = `
                            <span>${name} x ${qty}</span>
                            <span>Rp${total.toLocaleString("id-ID")}</span>
                        `;

                        summaryContainer.appendChild(summaryItem);
                    }
                });
            }

            // Saat klik tombol + atau -
            document.querySelectorAll(".quantity-btn").forEach(btn => {
                btn.addEventListener("click", updateSummary);
            });

            // Saat quantity diubah manual
            document.querySelectorAll(".quantity").forEach(input => {
                input.addEventListener("input", updateSummary);
            });
        });

        document.querySelector("button.konfirmasi-btn").addEventListener("click", () => {
            const nomorMeja = document.querySelector("select[name='meja']").value;
            const pesanan = [];

            document.querySelectorAll(".menu-item").forEach(item => {
                const jumlah = parseInt(item.querySelector(".quantity").value);
                if (jumlah > 0) {
                    pesanan.push({
                        id_menu: parseInt(item.dataset.id),
                        jumlah: jumlah
                    });
                }
            });

            if (pesanan.length === 0) {
                alert("Tidak ada pesanan yang dipilih!");
                return;
            }

            fetch("../src/pesananDb.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ nomor_meja: parseInt(nomorMeja), pesanan: pesanan }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Pesanan berhasil dikonfirmasi!");
                    window.location.reload();
                } else {
                    alert("Gagal menyimpan pesanan: " + data.message);
                }
            });
        });
    </script>
</body>
</html>
