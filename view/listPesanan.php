<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    // Tangani aksi POST dulu
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require('../src/listPesananPost.php'); // proses perubahan status
        header("Location: listPesanan.php"); // redirect ke halaman tampilan
        exit;
    }
    require('../src/listPesananDb.php');
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pesanan</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <link href="../output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body class="bg-gray-100 pt-[118px]">
    <div id="main" class="flex flex-col">
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

        <div class="flex justify-center gap-10">
            <div class="w-1/6 flex justify-center flex-col items-center bg-white shadow-md rounded-lg mt-6 ">
                <h1 class="text-2xl font-semibold mt-5">Pending</h1>
                <h1 class="text-3xl font-semibold my-10">5</h1>
            </div>

            <div class="w-1/6 flex justify-center flex-col items-center bg-white shadow-md rounded-lg mt-6 ">
                <h1 class="text-2xl font-semibold mt-5">Jumlah Antrian</h1>
                <h1 class="text-3xl font-semibold my-10"><?=$jumlahPreparing?></h1>
            </div>

            <div class="w-1/6 flex justify-center flex-col items-center bg-white shadow-md rounded-lg mt-6 ">
                <h1 class="text-2xl font-semibold mt-5">Siap Disajikan</h1>
                <h1 class="text-3xl font-semibold my-10"><?=$jumlahReady?></h1>
            </div>

        </div>

        <main class="flex items-center justify-center mt-12 mb-12">
            <div class="w-10/12 bg-white shadow-md rounded-lg">
                <div class="flex border-b border-gray-200">
                    <button id="pendingTab" class="tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-blue-500 text-blue-600 bg-blue-50">Pending</button>
                    <button id="confirmedTab" class="tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-transparent text-gray-500">Terkonfirmasi</button>
                </div>
                
                <div id="pendingSection" class="tab-content p-6">
                    <table class="w-full text-center">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">No</th>
                                <th class="py-3 px-2">Meja</th>
                                <th class="py-3 px-2">Nama Pelanggan</th>
                                <th class="py-3 px-2">Detail Pesanan</th>
                                <th class="py-3 px-2">Waktu</th>
                                <th class="py-3 px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pendingOrders)): ?>
                                <tr><td colspan="6" class="py-10 text-gray-500">Tidak ada pesanan pending saat ini.</td></tr>
                            <?php else: ?>
                                <?php foreach ($pendingOrders as $index => $row) : ?>
                                    <tr class="border-b">
                                        <td class="py-3 px-2"><?= $index + 1 ?></td>
                                        <td class="py-3 px-2">Meja <?= $row['nomor_meja'] ?></td>
                                        <td class="py-3 px-2"><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Take Away') ?></td>
                                        <td class="py-3 px-2">
                                            <button onclick="tampilkanDetail(<?= $row['id_pesanan'] ?>)" class="border rounded-md px-4 py-1 bg-gray-200 hover:bg-gray-300 transition">Lihat Detail</button>
                                        </td>
                                        <td class="py-3 px-2"><?= date('H:i', strtotime($row['waktu_pesan'])) ?></td>
                                        <td class="py-3 px-2">
                                            <div class="flex justify-center gap-2">
                                                <form method="POST" action="listPesanan.php" onsubmit="return confirm('Batalkan pesanan ini?');">
                                                    <input type="hidden" name="action" value="set_canceled">
                                                    <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                                                    <button type="submit" class="font-bold text-white bg-red-500 w-10 h-10 rounded-md hover:bg-red-600 transition">X</button>
                                                </form>
                                                <form method="POST" action="listPesanan.php" onsubmit="return confirm('Proses pesanan ini?');">
                                                    <input type="hidden" name="action" value="set_preparing">
                                                    <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                                                    <button type="submit" class="font-bold text-white bg-green-500 w-10 h-10 rounded-md hover:bg-green-600 transition">✓</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div id="confirmedSection" class="tab-content p-6 hidden">
                     <table class="w-full text-center">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">No</th>
                                <th class="py-3 px-2">Meja</th>
                                <th class="py-3 px-2">Detail Pesanan</th>
                                <th class="py-3 px-2">Waktu</th>
                                <th class="py-3 px-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($confirmedOrders)): ?>
                                <tr><td colspan="5" class="py-10 text-gray-500">Tidak ada pesanan yang sedang disiapkan.</td></tr>
                            <?php else: ?>
                                <?php foreach ($confirmedOrders as $index => $row) : ?>
                                    <tr class="border-b">
                                        <td class="py-3 px-2"><?= $index + 1 ?></td>
                                        <td class="py-3 px-2">Meja <?= $row['nomor_meja'] ?></td>
                                        <td class="py-3 px-2">
                                            <button onclick="tampilkanDetail(<?= $row['id_pesanan'] ?>)" class="border rounded-md px-4 py-1 bg-gray-200 hover:bg-gray-300 transition">Lihat Detail</button>
                                        </td>
                                        <td class="py-3 px-2"><?= date('H:i', strtotime($row['waktu_pesan'])) ?></td>
                                        <td class="py-3 px-2">
                                            <form method="POST" action="listPesanan.php">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                                                <select name="status" onchange="this.form.submit()" class="bg-white border border-gray-300 rounded px-3 py-2 text-sm shadow hover:border-blue-400 transition focus:outline-none">
                                                    <option value="Preparing" <?= $row['status'] === 'Preparing' ? 'selected' : '' ?>>Preparing</option>
                                                    <option value="Ready To Serve" <?= $row['status'] === 'Ready To Serve' ? 'selected' : '' ?>>Ready To Serve</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="reservasiModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
        <div class="bg-white w-1/3 max-w-lg rounded-lg shadow-xl p-6 relative">
            <button onclick="tutupModal()" class="absolute top-3 right-4 text-gray-500 hover:text-black text-3xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-center">Detail Menu Pesanan</h2>
            <div id="detailPesananContent" class="max-h-80 overflow-y-auto">
                <ul id="menuList" class="list-none text-left w-full px-2 text-gray-800 space-y-2">
                    </ul>
            </div>
        </div>
    </div>
    
<script src="../script/listPesanan.js"></script>
<script>
    const detailPesananData = <?= json_encode($semuaDetailPesanan) ?>;
</script>
</body>
</html>