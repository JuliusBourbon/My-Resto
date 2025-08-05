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
                <h1 class="text-2xl font-semibold mt-5">Jumlah Antrian</h1>
                <h1 class="text-3xl font-semibold my-10"><?=$jumlahPreparing?></h1>
            </div>

            <div class="w-1/6 flex justify-center flex-col items-center bg-white shadow-md rounded-lg mt-6 ">
                <h1 class="text-2xl font-semibold mt-5">Pesanan Selesai</h1>
                <h1 class="text-3xl font-semibold my-10"><?=$jumlahReady?></h1>
            </div>

            <div class="w-1/6 flex justify-center flex-col items-center bg-white shadow-md rounded-lg mt-6 ">
                <h1 class="text-2xl font-semibold mt-5">Pesanan Batal</h1>
                <h1 class="text-3xl font-semibold my-10">5</h1>
            </div>
        </div>

        <div class="flex items-center justify-center mt-20">
            <div class="w-10/12 bg-white shadow-md rounded-lg">
                <!-- Header Tabs -->
                <div class="flex items-center justify-between overflow-hidden">
                    <button id="pendingTab" class="text-xl bg-blue-400 w-1/2 text-center py-2 rounded-tl-lg font-semibold text-gray-800">Pending</button>
                    <button id="confirmBtn" class="text-xl bg-blue-300 w-1/2 text-center py-2 rounded-tr-lg font-semibold text-gray-600">Terkonfirmasi</button>
                </div>
                
                <!-- Pending Section -->
                <div id="pendingSection" class="flex p-8 justify-center">
                    <table class="w-full text-center m-10">
                        <thead>
                            <tr>
                                <th class="py-2">No</th>
                                <th class="py-2">Meja</th>
                                <th class="py-2">Nama</th>
                                <th class="py-2">Pesanan</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Waktu</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($row = $query->fetch_assoc()) : ?>
                                <tr>
                                    <td class="border py-2"><?= $no++ ?></td>
                                    <?php
                                        $counter = 1;
                                        if ($row['nomor_meja'] == 11) {
                                            $label = '11-' . $counter++;
                                        } else {
                                            $label = $row['nomor_meja'];
                                        }
                                    ?>
                                    <td class="border py-2"><?= 'Meja ' . $label ?></td>
                                    <td class="border py-2"><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                    <td class="border py-2">
                                        <button onclick="tampilkanDetail(<?= $row['id_pesanan'] ?>)" class="border rounded-sm w-1/2 bg-gray-300 hover:bg-gray-400 transition" id="Reservasi">Detail</button>
                                    </td>
                                    <td class="border py-2">
                                        <form method="POST" action="listPesanan.php">
                                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                                            <select name="status" onchange="this.form.submit()" class="bg-white border border-gray-300 rounded px-3 py-1 text-sm shadow hover:border-blue-400 transition focus:outline-none">
                                                <option value="Preparing" <?= $row['status'] === 'Preparing' ? 'selected' : '' ?>>Preparing</option>
                                                <option value="Ready To Serve" <?= $row['status'] === 'Ready To Serve' ? 'selected' : '' ?>>Ready To Serve</option>
                                            </select>
                                        </form>

                                    <td class="border py-2"><?= date('d-m-Y H:i', strtotime($row['waktu_pesan'])) ?></td>
                                    </td>
                                    <td class="border py-2">
                                        <div class="flex rounded-md justify-center">
                                            <input type="button" value="X" class="border border-gray-500 bg-red-400 text-black px-10 py-2 rounded-l-md cursor-pointer hover:bg-red-500 transition">
                                            <input type="button" value="✓" class="border border-gray-500 bg-green-400 text-black px-10 py-2 rounded-r-md cursor-pointer hover:bg-green-500 transition">
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
                <div id="confirmedSection" class="flex p-8 justify-center hidden">
                    <table class="w-full text-center m-10">
                        <thead>
                            <tr class="">
                                <th class="py-2">No</th>
                                <th class="py-2">Meja</th>
                                <th class="py-2">Nama</th>
                                <th class="py-2">Pesanan</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border py-2">1</td>
                                <td class="border py-2">Meja 1</td>
                                <td class="border py-2">Tes</td>
                                <td class="border py-2"><input type="button" value="Detail" class="border rounded-sm w-1/2 bg-gray-300"></td>
                                <td class="border py-2">SSS</td>
                                <td class="border py-2">
                                    <div class="flex rounded-md justify-center">
                                        <input type="button" value="X" class="border border-gray-500 bg-red-400 text-black px-10 py-2 rounded-l-md cursor-pointer hover:bg-red-500 transition">
                                        <input type="button" value="✓" id="" class="border border-gray-500 bg-green-400 text-black px-10 py-2 rounded-r-md cursor-pointer hover:bg-green-500 transition">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="reservasiModal" class="fixed top-0 left-0 right-0 z-50 flex justify-center items-center h-screen hidden">
        <div class="bg-white w-1/3 rounded-lg shadow-lg p-6 relative">
            <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-black text-2xl font-bold">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Detail Menu Pesanan</h2>
            <ul id="menuList" class="list-disc text-left w-full px-6 text-gray-700 space-y-1">
                <!-- Diisi via JS -->
            </ul>
        </div>
    </div>
    
<script>
    const detailPesananData = <?= json_encode($semuaDetailPesanan) ?>;
</script>
<script src="../script/notifikasi.js"></script>
</body>
</html>