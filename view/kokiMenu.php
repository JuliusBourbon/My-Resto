<?php

    require('../src/kokiMenuDb.php');
    $currentPage = basename($_SERVER['PHP_SELF']); // ambil nama file saat ini
    
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
                    <a href="kokiMenu.php" class="py-2 font-semibold transition <?= $currentPage === 'kokiMenu.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">List Menu</a>
                </div>
                <div class="flex items-center gap-6 pt-1">
                    <a href="listPesanan.php" class="py-2 font-semibold transition <?= $currentPage === 'listPesanan.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">List Pesanan</a>
                </div>
            </div>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-grow flex items-center justify-center p-6 gap-6">
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
                        <button 
                            class="kategori-btn p-4 rounded-lg text-center font-semibold text-gray-700 shadow-sm h-36 flex items-center justify-center <?= $bgClass ?>"
                            data-kategori="<?= $row['id_kategori'] ?>">
                            <span><?= $row['nama_kategori'] ?></span>
                        </button>
                    <?php endwhile; ?>
                </div>
                
                <hr class="border-t border-gray-200">

                <div id="menu-container" class="grid grid-cols-4 gap-5 overflow-y-auto pr-2">
                </div>
            </div>
        </main>
    </div>

    <script>
        let selectedQuantities = {}; 
        let allMenuItems = {}; 
        let selectedKategori = null;

        function updateMenuContainer(data) {
            const container = document.querySelector('#menu-container');
            container.innerHTML = ''; 

            data.forEach(item => {
                if (!allMenuItems[item.id_menu]) {
                    allMenuItems[item.id_menu] = {
                        nama: item.nama,
                        harga: parseInt(item.harga)
                    };
                }

                let bg = '';
                switch (item.nama_kategori) {
                    case 'Sarapan': bg = 'bg-[#C8F6BC]'; break;
                    case 'Hidangan Utama': bg = 'bg-[#FFD27E]'; break;
                    case 'Minuman': bg = 'bg-[#A2F9FF]'; break;
                    case 'Penutup': bg = 'bg-[#FEC0FF]'; break;
                    default: bg = 'bg-gray-200';
                }

                const el = document.createElement('div');
                el.className = `menu-item p-4 rounded-lg flex flex-col justify-between shadow-sm h-full ${bg}`;
                el.dataset.id_menu = item.id_menu;
                const currentQuantity = selectedQuantities[item.id_menu] || 0;

                el.innerHTML = `
                    <div class="flex flex-col items-center justify-center gap-2">
                        <h3 class="font-bold text-gray-800">${item.nama}</h3>
                        <p class="text-sm text-gray-700 font-medium">Rp${parseInt(item.harga).toLocaleString('id-ID')}</p>
                        <form method="POST" action="">
                            <input type="hidden" name="id_menu" value="${item.id_menu}">
                            <select name="status_ketersediaan" onchange="this.form.submit()" class="bg-white border border-gray-300 rounded px-3 py-1 text-sm shadow hover:border-blue-400 transition focus:outline-none">
                                <option value="Tersedia" ${item.status_ketersediaan === 'Tersedia' ? 'selected' : ''}>Tersedia</option>
                                <option value="Tidak Tersedia" ${item.status_ketersediaan === 'Tidak Tersedia' ? 'selected' : ''}>Tidak Tersedia</option>
                            </select>
                        </form>
                    </div>
                `;

                container.appendChild(el);
            });

            bindQuantityButtons();
        }

        function fetchMenu(kategoriId = null) {
            let url = '../src/menuFiltered.php';
            if (kategoriId) {
                url += `?kategori_id=${kategoriId}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    updateMenuContainer(data);
                });
        }


        document.addEventListener("DOMContentLoaded", function () {
            fetch('../src/menuFiltered.php')
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        allMenuItems[item.id_menu] = {
                            nama: item.nama,
                            harga: parseInt(item.harga)
                        };
                    });
                    updateMenuContainer(data);
                    updateOrderSummary(); 
                });

            document.querySelectorAll('.kategori-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const kategoriId = this.dataset.kategori;

                    if (selectedKategori === kategoriId) {
                        selectedKategori = null;
                        fetchMenu(); 
                    } else {
                        selectedKategori = kategoriId;
                        fetchMenu(kategoriId); 
                    }
                });
            });

        });
    </script>
</body>
</html>
