<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../src/notifikasiPost.php';
    exit;
}

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/notifikasidb.php';

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notifikasi - MyResto</title>

  <link href="<?= $base_url ?>/output.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-gray-100 pt-[118px]">
  <div id="main" class="flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200">
      <div class="relative flex items-center justify-center px-10 py-4">
        <div class="absolute left-10 top-1/2 -translate-y-1/2">
          <img src="<?= $base_url ?>/img/myresto_icon.jpg" alt="Logo" class="w-18 h-18 object-contain" />
        </div>
        <span class="text-2xl font-bold">MyResto</span>
        <div class="absolute right-10 top-1/2 -translate-y-1/2">
          <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
        </div>
      </div>

      <!-- Navbar Menu -->
      <div class="px-10 flex gap-10">
        <?php
          function navActive($path) {
              global $currentPath;
              return $currentPath === $path ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2';
          }
        ?>
        <a href="<?= $base_url ?>/meja" class="py-2 font-semibold transition <?= navActive('/My-Resto/meja') ?>">Meja</a>
        <a href="<?= $base_url ?>/order" class="py-2 font-semibold transition <?= navActive('/My-Resto/order') ?>">Pesanan</a>
        <a href="<?= $base_url ?>/notifikasi" class="py-2 font-semibold transition <?= navActive('/My-Resto/notifikasi') ?>">Notifikasi</a>
      </div>
    </nav>

    <!-- Konten -->
    <main class="flex items-start justify-center mt-12 mb-12">
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
                <th class="py-3 px-2">Meja</th>
                <th class="py-3 px-2">Detail Pesanan</th>
                <th class="py-3 px-2">Waktu</th>
                <th class="py-3 px-2">Status</th>
                <th class="py-3 px-2">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($pendingNotifications)): ?>
                <tr><td colspan="5" class="py-10 text-gray-500">Tidak ada notifikasi saat ini.</td></tr>
              <?php else: ?>
                <?php foreach ($pendingNotifications as $row): ?>
                  <tr class="border-b">
                    <td class="py-3 px-2">Meja <?= $row['nomor_meja'] ?></td>
                    <td class="py-3 px-2">
                      <button onclick="tampilkanDetail(<?= $row['id_pesanan'] ?>)" class="border rounded-md px-4 py-1 bg-gray-200 hover:bg-gray-300 transition">Lihat Detail</button>
                    </td>
                    <td class="py-3 px-2"><?= date('H:i', strtotime($row['waktu_pesan'])) ?></td>
                    <td class="py-3 px-2 font-semibold <?= match($row['status']) {
                        'Canceled' => 'text-red-600',
                        'Ready To Serve' => 'text-green-600',
                        'Preparing' => 'text-yellow-600',
                        default => 'text-gray-800',
                    } ?>">
                      <?= $row['status'] ?>
                    </td>
                    <td class="py-3 px-2">
                      <div class="flex justify-center items-center gap-2 h-10">
                        <?php if ($row['status'] === 'Ready To Serve'): ?>
                          <form method="POST" action="<?= $base_url ?>/src/notifikasiPost.php" onsubmit="return confirm('Konfirmasi pesanan telah disajikan?');">
                            <input type="hidden" name="action" value="set_served" />
                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>" />
                            <button type="submit" class="font-bold text-white bg-green-500 px-4 h-10 rounded-md hover:bg-green-600 transition">Selesai</button>
                          </form>
                        <?php elseif ($row['status'] === 'Canceled'): ?>
                          <form method="POST" action="<?= $base_url ?>/src/notifikasiPost.php" onsubmit="return confirm('Kosongkan meja dan batalkan?');">
                            <input type="hidden" name="action" value="set_finish_order" />
                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>" />
                            <button type="submit" class="font-bold text-white bg-red-500 w-10 h-10 rounded-md hover:bg-red-600 transition" title="Batalkan">X</button>
                          </form>
                          <form method="POST" action="<?= $base_url ?>/src/notifikasiPost.php" onsubmit="return confirm('Izinkan pesan ulang?');">
                            <input type="hidden" name="action" value="set_reorder" />
                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>" />
                            <button type="submit" class="font-bold text-white bg-blue-500 w-10 h-10 rounded-md hover:bg-blue-600 transition" title="Pesan Ulang">↻</button>
                          </form>
                        <?php else: ?>
                          <span class="text-sm text-gray-400">-</span>
                        <?php endif; ?>
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
                <th class="py-3 px-2">Meja</th>
                <th class="py-3 px-2">Nama Pelanggan</th>
                <th class="py-3 px-2">Detail</th>
                <th class="py-3 px-2">Waktu</th>
                <th class="py-3 px-2">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($finishedOrders)): ?>
                <tr><td colspan="5" class="py-10 text-gray-500">Belum ada riwayat pesanan selesai.</td></tr>
              <?php else: ?>
                <?php foreach ($finishedOrders as $row): ?>
                  <tr class="border-b">
                    <td class="py-3 px-2">Meja <?= $row['nomor_meja'] ?></td>
                    <td class="py-3 px-2"><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Take Away') ?></td>
                    <td class="py-3 px-2">
                      <button onclick="tampilkanDetail(<?= $row['id_pesanan'] ?>)" class="border rounded-md px-4 py-1 bg-gray-200 hover:bg-gray-300 transition">Lihat Detail</button>
                    </td>
                    <td class="py-3 px-2"><?= date('d/m/Y H:i', strtotime($row['waktu_pesan'])) ?></td>
                    <td class="py-3 px-2"><span class="font-semibold text-gray-500"><?= $row['status'] ?></span></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal -->
  <div id="reservasiModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
    <div class="bg-white w-1/3 max-w-lg rounded-lg shadow-xl p-6 relative">
      <button onclick="tutupModal()" class="absolute top-3 right-4 text-gray-500 hover:text-black text-3xl font-bold">&times;</button>
      <h2 class="text-2xl font-bold mb-4 text-center">Detail Menu Pesanan</h2>
      <div id="detailPesananContent" class="max-h-80 overflow-y-auto">
        <ul id="menuList" class="list-none text-left w-full px-2 text-gray-800 space-y-2"></ul>
      </div>
    </div>
  </div>

  <script src="<?= $base_url ?>/script/listPesanan.js"></script>
  <script>
    const detailPesananData = <?= json_encode($semuaDetailPesanan) ?>;
  </script>
</body>
</html>
