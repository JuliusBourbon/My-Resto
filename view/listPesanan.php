<?php
session_start();
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../src/listPesananPost.php';
    header("Location: {$base_url}/list-pesanan");
    exit;
}

require_once __DIR__ . '/../src/listPesananDb.php';
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>List Pesanan - MyResto</title>

  <link href="<?= $base_url ?>/output.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-gray-100 pt-[118px]">
  <div id="main" class="flex flex-col">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200">
      <div class="relative flex items-center justify-center px-10 py-4">
        <div class="absolute left-10 top-1/2 -translate-y-1/2">
          <img src="<?= $base_url ?>/img/myresto_icon.jpg" alt="Logo" class="w-18 h-18 object-contain" />
        </div>
        <span class="text-2xl font-bold">MyResto</span>
        <div class="absolute right-10 top-1/2 -translate-y-1/2">
          <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="px-10 flex gap-10">
        <?php
          function navActive($path) {
              global $currentPath;
              return $currentPath === $path ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2';
          }
        ?>
        <a href="<?= $base_url ?>/koki-menu" class="py-2 font-semibold transition <?= navActive('/My-Resto/koki-menu') ?>">List Menu</a>
        <a href="<?= $base_url ?>/list-pesanan" class="py-2 font-semibold transition <?= navActive('/My-Resto/list-pesanan') ?>">List Pesanan</a>
      </div>
    </nav>

    <!-- Ringkasan -->
    <div class="flex justify-center gap-10 mt-6">
      <div class="w-1/6 bg-white shadow-md rounded-lg flex flex-col items-center py-6">
        <h1 class="text-xl font-semibold">Pending</h1>
        <h1 class="text-3xl mt-4 font-bold">5</h1>
      </div>
      <div class="w-1/6 bg-white shadow-md rounded-lg flex flex-col items-center py-6">
        <h1 class="text-xl font-semibold">Jumlah Antrian</h1>
        <h1 class="text-3xl mt-4 font-bold"><?= $jumlahPreparing ?></h1>
      </div>
      <div class="w-1/6 bg-white shadow-md rounded-lg flex flex-col items-center py-6">
        <h1 class="text-xl font-semibold">Siap Disajikan</h1>
        <h1 class="text-3xl mt-4 font-bold"><?= $jumlahReady ?></h1>
      </div>
    </div>

    <!-- Konten -->
    <main class="flex items-center justify-center mt-12 mb-12">
      <div class="w-10/12 bg-white shadow-md rounded-lg">
        <!-- Tabs -->
        <div class="flex border-b border-gray-200">
          <button id="pendingTab" class="tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-blue-500 text-blue-600 bg-blue-50">Pending</button>
          <button id="confirmedTab" class="tab-button w-1/2 py-3 text-xl font-semibold border-b-4 border-transparent text-gray-500">Terkonfirmasi</button>
        </div>

        <!-- Pending Section -->
        <div id="pendingSection" class="tab-content p-6">
          <table class="w-full text-center">
            <thead class="bg-gray-50">
              <tr>
                <th>No</th><th>Meja</th><th>Nama</th><th>Detail</th><th>Waktu</th><th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($pendingOrders)): ?>
                <tr><td colspan="6" class="py-10 text-gray-500">Tidak ada pesanan pending saat ini.</td></tr>
              <?php else: ?>
                <?php foreach ($pendingOrders as $index => $row): ?>
                  <tr class="border-b">
                    <td><?= $index + 1 ?></td>
                    <td>Meja <?= $row['nomor_meja'] ?></td>
                    <td><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Take Away') ?></td>
                    <td>
                      <button onclick="tampilkanDetail(<?= $row['id_pesanan'] ?>)" class="border px-4 py-1 rounded bg-gray-200 hover:bg-gray-300">Lihat Detail</button>
                    </td>
                    <td><?= date('H:i', strtotime($row['waktu_pesan'])) ?></td>
                    <td>
                      <div class="flex justify-center gap-2">
                        <form method="POST" action="<?= $base_url ?>/list-pesanan" onsubmit="return confirm('Batalkan pesanan ini?');">
                          <input type="hidden" name="action" value="set_canceled">
                          <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                          <button class="w-10 h-10 bg-red-500 text-white rounded hover:bg-red-600">X</button>
                        </form>
                        <form method="POST" action="<?= $base_url ?>/list-pesanan" onsubmit="return confirm('Proses pesanan ini?');">
                          <input type="hidden" name="action" value="set_preparing">
                          <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                          <button class="w-10 h-10 bg-green-500 text-white rounded hover:bg-green-600">✓</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Confirmed Section -->
        <div id="confirmedSection" class="tab-content p-6 hidden">
          <table class="w-full text-center">
            <thead class="bg-gray-50">
              <tr>
                <th>No</th><th>Meja</th><th>Detail</th><th>Waktu</th><th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($confirmedOrders)): ?>
                <tr><td colspan="5" class="py-10 text-gray-500">Tidak ada pesanan disiapkan.</td></tr>
              <?php else: ?>
                <?php foreach ($confirmedOrders as $index => $row): ?>
                  <tr class="border-b">
                    <td><?= $index + 1 ?></td>
                    <td>Meja <?= $row['nomor_meja'] ?></td>
                    <td>
                      <button onclick="tampilkanDetail(<?= $row['id_pesanan'] ?>)" class="border px-4 py-1 rounded bg-gray-200 hover:bg-gray-300">Lihat Detail</button>
                    </td>
                    <td><?= date('H:i', strtotime($row['waktu_pesan'])) ?></td>
                    <td>
                      <form method="POST" action="<?= $base_url ?>/list-pesanan">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                        <select name="status" onchange="this.form.submit()" class="bg-white border border-gray-300 rounded px-3 py-1 text-sm shadow focus:outline-none">
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

  <!-- Modal Detail -->
  <div id="reservasiModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
    <div class="bg-white w-1/3 max-w-lg rounded-lg shadow-xl p-6 relative">
      <button onclick="tutupModal()" class="absolute top-3 right-4 text-gray-500 hover:text-black text-3xl font-bold">&times;</button>
      <h2 class="text-2xl font-bold mb-4 text-center">Detail Menu Pesanan</h2>
      <div id="detailPesananContent" class="max-h-80 overflow-y-auto">
        <ul id="menuList" class="list-none px-2 text-gray-800 space-y-2"></ul>
      </div>
    </div>
  </div>

  <script src="<?= $base_url ?>/script/listPesanan.js"></script>
  <script>const detailPesananData = <?= json_encode($semuaDetailPesanan) ?>;</script>
</body>
</html>
