<?php
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../src/historiDb.php';
    require_once __DIR__ . '/../src/middleware.php';
    requireRole('kasir');
    $nama = $_SESSION['nama'] ?? $_SESSION['email'] ?? 'User';
    $role = $_SESSION['role'] ?? '-';
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
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
    <div id="main" class="flex flex-col min-h-screen">
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

        <main class="w-full p-6">
            <div class="bg-white rounded-xl shadow-lg p-8 mx-auto max-w-4xl">
                <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">Histori Pembayaran</h1>
                <div class="flex justify-center gap-6">
                    <div class="flex flex-col text-center justify-center px-10 shadow-lg py-2 bg-gray-100 mb-10 rounded-lg">
                        <h1 class="mb-8 text-xl">Jumlah Transaksi</h1>
                        <h1 id="jumlah-transaksi" class="mb-5 text-2xl font-bold text-blue-600">0</h1>
                    </div>
                    <div class="flex flex-col text-center justify-center px-10 shadow-lg py-2 bg-gray-100 mb-10 rounded-lg">
                        <h1 class="mb-8 text-xl">Jumlah Pendapatan</h1>
                        <h1 id="jumlah-pendapatan" class="mb-5 text-2xl font-bold text-green-600">Rp0</h1>
                    </div>
                </div>
                <div class="mb-6 bg-gray-100 p-4 rounded-lg shadow-lg">
                    <form id="filter-form" class="flex items-center gap-4">
                        <div>
                            <label for="tanggal_awal" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" id="tanggal_awal" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2">
                        </div>
                        <div>
                            <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" id="tanggal_akhir" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2">
                        </div>
                        <div class="self-end">
                            <button type="submit" class="bg-green-600 text-white py-2 px-6 rounded-md hover:bg-green-700 transition font-semibold">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <table class="min-w-full text-left">
                    <thead class="border-b">
                        <tr>
                            <th class="py-3 px-4 font-semibold text-gray-600">Nama Pelanggan</th>
                            <th class="py-3 px-4 font-semibold text-gray-600">Waktu Pembayaran</th>
                            <th class="py-3 px-4 font-semibold text-gray-600">Metode</th>
                            <th class="py-3 px-4 font-semibold text-gray-600 text-right">Total Harga</th>
                            <th class="py-3 px-4 font-semibold text-gray-600 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="histori-tbody">
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <div id="detailModal" class="flex fixed inset-0 bg-opacity-60 hidden items-center justify-center z-50">
        <div class="bg-white w-1/3 max-w-lg rounded-lg shadow-xl p-6 relative">
        <button onclick="tutupModal()" class="absolute top-3 right-4 text-gray-500 hover:text-black text-3xl font-bold">&times;</button>
        <h2 class="text-2xl font-bold mb-4 text-center">Detail Menu Pesanan</h2>
        <div id="detailPesananContent" class="max-h-80 overflow-y-auto">
            <ul id="menuList" class="list-none text-left w-full px-2 text-gray-800 space-y-2"></ul>
        </div>
        </div>
    </div>

    


    <script>
        const modal = document.getElementById('detailModal');
        const menuList = document.getElementById('menuList');
        const mainContent = document.getElementById('main');
        const historiTbody = document.getElementById('histori-tbody');
        const filterForm = document.getElementById('filter-form');
        const tglAwalInput = document.getElementById('tanggal_awal');
        const tglAkhirInput = document.getElementById('tanggal_akhir');
        const BASE_URL = "<?= $base_url ?>";

        function updateStatistik(data) {
            const elJumlahTransaksi = document.getElementById('jumlah-transaksi');
            const elJumlahPendapatan = document.getElementById('jumlah-pendapatan');

            const jumlahTransaksi = data.length;
            const jumlahPendapatan = data.reduce((total, item) => total + parseFloat(item.total_harga), 0);

            elJumlahTransaksi.textContent = jumlahTransaksi;
            elJumlahPendapatan.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(jumlahPendapatan);
        }

        function fetchAndRenderHistori(startDate, endDate) {
            historiTbody.innerHTML = `<tr><td colspan="5" class="text-center p-8 text-gray-500">Memuat data...</td></tr>`;
            let url = `${BASE_URL}/src/historiFilter.php`;
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    updateStatistik(data);

                    historiTbody.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(row => {
                            const tr = document.createElement('tr');
                            tr.className = 'border-b hover:bg-gray-50';
                            const tanggal = new Date(row.tanggal_pembayaran);
                            const formattedDate = new Intl.DateTimeFormat('id-ID', { dateStyle: 'long', timeStyle: 'short' }).format(tanggal);
                            const formattedHarga = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(row.total_harga);

                            tr.innerHTML = `
                                <td class="py-4 px-4">${row.nama_pelanggan}</td>
                                <td class="py-4 px-4">${formattedDate}</td>
                                <td class="py-4 px-4">${row.metode_pembayaran}</td>
                                <td class="py-4 px-4 text-right">${formattedHarga}</td>
                                <td class="py-4 px-4 text-center">
                                    <button class="detail-btn bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition text-sm font-semibold"
                                            data-id-pesanan="${row.id_pesanan}">
                                        Detail Pesanan
                                    </button>
                                </td>
                            `;
                            historiTbody.appendChild(tr);
                        });
                    } else {
                        historiTbody.innerHTML = `<tr><td colspan="5" class="text-center p-8 text-gray-500">Tidak ada data untuk rentang tanggal ini.</td></tr>`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching history:', error);
                    historiTbody.innerHTML = `<tr><td colspan="5" class="text-center p-8 text-red-500">Gagal memuat data.</td></tr>`;
                });
        }

        function tampilkanDetail(idPesanan) {
            menuList.innerHTML = "<li>Memuat data...</li>";
            openModal();

            fetch(`${BASE_URL}/src/historiGet.php?id=${idPesanan}`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data.');
                    return response.json();
                })
                .then(items => {
                    menuList.innerHTML = "";
                    if (items.length > 0) {
                        items.forEach((item, index) => {
                            const li = document.createElement("li");
                            li.className = "py-1";
                            li.textContent = `${index + 1}. ${item.nama} x${item.jumlah}`;
                            menuList.appendChild(li);
                        });
                    } else {
                        menuList.innerHTML = "<li class='text-red-500'>Tidak ada detail item untuk pesanan ini.</li>";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    menuList.innerHTML = `<li class='text-red-500'>${error.message}</li>`;
                });
        }

        function openModal() {
            modal.classList.remove('hidden');
            mainContent.classList.add('blur-sm');
        }

        function closeModal() {
            modal.classList.add('hidden');
            mainContent.classList.remove('blur-sm');
        }

        
        filterForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const startDate = tglAwalInput.value;
            const endDate = tglAkhirInput.value;
            if (!startDate || !endDate) {
                alert('Silakan pilih kedua tanggal terlebih dahulu.');
                return;
            }
            fetchAndRenderHistori(startDate, endDate);
        });

        historiTbody.addEventListener('click', function(event) {
            const detailBtn = event.target.closest('.detail-btn');
            if (detailBtn) {
                tampilkanDetail(detailBtn.dataset.idPesanan);
            }
        });
        
        modal.querySelector('button').addEventListener('click', closeModal);
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        // === INISIALISASI HALAMAN ===
        const hariIni = new Date().toISOString().split('T')[0];
        tglAwalInput.value = hariIni;
        tglAkhirInput.value = hariIni;
        fetchAndRenderHistori(hariIni, hariIni);

    </script>
  <!-- <script src="<?= $base_url ?>/script/pembayaran.js"></script> -->
</body>
</html>
