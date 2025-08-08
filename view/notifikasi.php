<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      require_once __DIR__ . '/../src/notifikasiPost.php';
      exit;
  }

  require_once __DIR__ . '/../config.php';
  require_once __DIR__ . '/../src/notifikasidb.php';
  require_once __DIR__ . '/../src/middleware.php';
  requireRole('pelayan');
  $nama = $_SESSION['nama'] ?? $_SESSION['email'] ?? 'User';
  $role = $_SESSION['role'] ?? '-';
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
        <div class="flex items-center gap-6 pt-1">
          <a href="<?= $base_url ?>/meja" class=" flex gap-3 py-2 font-semibold transition <?= $currentPath === '/My-Resto/meja' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 7l2 9M8 7l-2 9M5 7h14m2 5H3"/></svg>
            Meja
          </a>
        </div>
        <div class="flex items-center gap-6 pt-1">
          <a href="<?= $base_url ?>/order" class="flex gap-3 py-2 font-semibold transition <?= $currentPath === '/My-Resto/order' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m17.275 18.125l-.425-.425q-.225-.225-.537-.225t-.538.225t-.225.525t.225.525l.975.975q.225.225.525.225t.525-.225l2.425-2.375q.225-.225.225-.538t-.225-.537t-.538-.225t-.537.225zM17 9q.425 0 .713-.288T18 8t-.288-.712T17 7H7q-.425 0-.712.288T6 8t.288.713T7 9zm1 14q-2.075 0-3.537-1.463T13 18t1.463-3.537T18 13t3.538 1.463T23 18t-1.463 3.538T18 23M3 21.875V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v5.5q0 .425-.35.688t-.775.137q-.7-.175-1.425-.25T17 11H7q-.425 0-.712.288T6 12t.288.713T7 13h6.1q-.425.425-.787.925T11.675 15H7q-.425 0-.712.288T6 16t.288.713T7 17h4.075q-.05.25-.062.488T11 18q0 .65.125 1.275t.325 1.25q.125.275-.1.438t-.425-.038l-.075-.075q-.15-.15-.35-.15t-.35.15l-.8.8q-.15.15-.35.15t-.35-.15l-.8-.8q-.15-.15-.35-.15t-.35.15l-.8.8q-.15.15-.35.15t-.35-.15l-.8-.8q-.15-.15-.35-.15t-.35.15l-.8.8z"/></svg>
          Pesanan
          </a>
        </div>
        <div class="flex items-center gap-6 pt-1">
          <a href="<?= $base_url ?>/notifikasi" class="flex gap-3 py-2 font-semibold transition <?= $currentPath === '/My-Resto/notifikasi' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
              <path d="M5.85 3.5a.75.75 0 0 0-1.117-1 9.719 9.719 0 0 0-2.348 4.876.75.75 0 0 0 1.479.248A8.219 8.219 0 0 1 5.85 3.5ZM19.267 2.5a.75.75 0 1 0-1.118 1 8.22 8.22 0 0 1 1.987 4.124.75.75 0 0 0 1.48-.248A9.72 9.72 0 0 0 19.266 2.5Z" />
              <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 0 0 5.25 9v.75a8.217 8.217 0 0 1-2.119 5.52.75.75 0 0 0 .298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 1 0 7.48 0 24.583 24.583 0 0 0 4.83-1.244.75.75 0 0 0 .298-1.205 8.217 8.217 0 0 1-2.118-5.52V9A6.75 6.75 0 0 0 12 2.25ZM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 0 0 4.496 0l.002.1a2.25 2.25 0 1 1-4.5 0Z" clip-rule="evenodd" />
            </svg>
          Notifikasi
          </a>
        </div>
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
                <th class="py-3 px-2">Nama Pelanggan</th>
                <th class="py-3 px-2">Detail Pesanan</th>
                <th class="py-3 px-2">Waktu</th>
                <th class="py-3 px-2">Status</th>
                <th class="py-3 px-2">Note</th>
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
                    <td class="py-3 px-2 text-blue-700"><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Take Away') ?></td>
                    <td class="py-3 px-2">
                      <button onclick="tampilkanDetail(<?= $row['id_pesanan'] ?>)" class="border rounded-md px-4 py-1 bg-gray-200 hover:bg-gray-300 transition">Lihat Detail</button>
                    </td>
                    <td class="py-3 px-2"><?= date('H:i', strtotime($row['waktu_pesan'])) ?></td>
                    <td class="py-3 px-2 font-semibold <?= match($row['status']) {
                        'Canceled' => 'text-red-600',
                        'Ready To Serve' => 'text-green-600',
                        'Preparing' => 'text-yellow-600',
                        default => 'text-blue-700',
                    } ?>">
                      <?= $row['status'] ?>
                    </td>
                    <td class="py-3 px-2 max-w-xs overflow-hidden text-ellipsis whitespace-nowrap" title="<?= htmlspecialchars($row['note']) ?>">
                        <?= htmlspecialchars($row['note']) ?>
                    </td>
                    <td class="py-3 px-2">
                      <div class="flex justify-center items-center gap-2 h-10">
                        <?php if ($row['status'] === 'Ready To Serve'): ?>
                            <form method="POST" action="<?= $base_url ?>/src/notifikasiPost.php">
                                <input type="hidden" name="action" value="set_served" />
                                <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>" />
                                <button type="button" class="confirm-action-btn font-bold text-white bg-green-500 px-4 h-10 rounded-md hover:bg-green-600 transition"
                                        data-message="Apakah Anda yakin pesanan ini sudah disajikan ke pelanggan?">
                                    Sajikan
                                </button>
                            </form>
                        <?php elseif ($row['status'] === 'Canceled'): ?>
                            <form method="POST" action="<?= $base_url ?>/src/notifikasiPost.php">
                                <input type="hidden" name="action" value="set_finish_order" />
                                <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>" />
                                <button type="button" class="confirm-action-btn font-bold text-white bg-red-500 w-10 h-10 rounded-md hover:bg-red-600 transition" 
                                        title="Batalkan Pesanan" data-message="Batalkan seluruh pesanan dan kosongkan meja?">
                                    X
                                </button>
                            </form>
                            <form method="POST" action="<?= $base_url ?>/src/notifikasiPost.php">
                                <input type="hidden" name="action" value="set_reorder" />
                                <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>" />
                                <button type="button" class="confirm-action-btn font-bold text-white bg-blue-500 w-10 h-10 rounded-md hover:bg-blue-600 transition" 
                                        title="Pesan Ulang" data-message="Izinkan pelanggan untuk memesan ulang? Status pesanan akan kembali ke 'Reservasi'.">
                                    ↻
                                </button>
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
                    <td class="py-3 px-2 text-blue-700"><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Take Away') ?></td>
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
  <div id="reservasiModal" class="fixed inset-0 bg-opacity-60 hidden items-center justify-center z-50">
    <div class="bg-white w-1/3 max-w-lg rounded-lg shadow-xl p-6 relative">
      <button onclick="tutupModal()" class="absolute top-3 right-4 text-gray-500 hover:text-black text-3xl font-bold">&times;</button>
      <h2 class="text-2xl font-bold mb-4 text-center">Detail Menu Pesanan</h2>
      <div id="detailPesananContent" class="max-h-80 overflow-y-auto">
        <ul id="menuList" class="list-none text-left w-full px-2 text-gray-800 space-y-2"></ul>
      </div>
    </div>
  </div>

  <div id="confirmationModal" class="fixed inset-0 bg-opacity-60 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl p-6 relative">
        <h2 id="modalTitle" class="text-2xl font-bold mb-4 text-center">Konfirmasi Tindakan</h2>
        <p id="modalMessage" class="text-center text-gray-600 mb-6">Apakah Anda yakin?</p>
        
        <div class="flex justify-end gap-4">
            <button id="modalCancelBtn" class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">Batal</button>
            <button id="modalConfirmBtn" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">Ya, Lanjutkan</button>
        </div>
    </div>
  </div>

  <script src="<?= $base_url ?>/script/listPesanan.js"></script>
  <script>
    const detailPesananData = <?= json_encode($semuaDetailPesanan) ?>;
  </script>
</body>
</html>
