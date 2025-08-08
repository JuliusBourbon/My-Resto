<?php
  require_once __DIR__ . '/../config.php';
  require_once __DIR__ . '/../src/pesananDb.php';
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
  <title>Order Pesanan - MyResto</title>

  <!-- CSS dan Font -->
  <link href="<?= $base_url ?>/output.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    body { font-family: 'Poppins', sans-serif; }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; appearance: textfield; }
  </style>
</head>
<body class="bg-gray-50 pt-[125px]">
  <div class="flex flex-col min-h-screen">
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
    <main class="flex-grow flex p-6 gap-6">
      <!-- Kiri: Menu -->
      <div class="w-[65%] flex flex-col gap-6">
        <div class="relative">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
          </div>
          
          <input type="text" id="searchInput" placeholder="Cari menu..." class="w-full bg-white pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Kategori -->
        <h1 class=" text-center text-2xl font-semibold">Kategori</h1>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
          <?php while ($row = $kategori->fetch_assoc()) :
            $bgMap = [
              'Sarapan' => 'bg-[#C8F6BC]',
              'Hidangan Utama' => 'bg-[#FFD27E]',
              'Minuman' => 'bg-[#A2F9FF]',
              'Penutup' => 'bg-[#FEC0FF]'
            ];
            $bgClass = $bgMap[$row['nama_kategori']] ?? 'bg-gray-200';
          ?>
          <button class="kategori-btn p-4 rounded-lg text-center hover:text-black font-semibold text-gray-700 hover:border-1 shadow-sm text-xl h-36 flex items-center justify-center <?= $bgClass ?>" data-kategori="<?= $row['id_kategori'] ?>">
            <?= $row['nama_kategori'] ?>
          </button>
          <?php endwhile; ?>
        </div>

        <hr class="border-t border-gray-200" />

        <!-- Daftar Menu -->
         <h1 class=" text-center text-2xl font-semibold">Menu</h1>
        <div id="menu-container" class="grid grid-cols-2 lg:grid-cols-4 gap-5 overflow-y-auto pr-2"></div>
      </div>

      <!-- Kanan: Ringkasan Order -->
      <div class="w-[35%] flex justify-center items-start pt-10">
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col w-3/4">
          <form method="GET" class="w-full flex flex-col">
            <label class="block font-semibold mb-2 text-center text-xl">Pilih Meja</label>
            <select name="meja" class="w-full p-2 mb-4 border rounded" onchange="this.form.submit()" required>
              <option value="">Pilih Meja</option>
              <?php
              mysqli_data_seek($mejaReserved, 0); // Reset pointer loop jika diperlukan
                while ($row = $mejaReserved->fetch_assoc()) :
                    // Cek jika nomor meja adalah 11
                    if ($row['nomor'] == 11) {
                        // Ambil digit terakhir dari id_meja. Contoh: 15 % 10 = 5
                        $sub_nomor = $row['id_meja'] % 10; 
                        $label = '11-' . $sub_nomor;
                    } else {
                        $label = $row['nomor'];
                    }

                    $selected = isset($_GET['meja']) && $_GET['meja'] == $row['id_meja'] ? 'selected' : '';
                ?>
                    <option value="<?= $row['id_meja'] ?>" <?= $selected ?>>Meja <?= $label ?></option>
              <?php endwhile; ?>
            </select>
          </form>

        <?php if ($pesananNama): ?>
            <p class="text-center font-bold text-lg">Atas Nama: <?= htmlspecialchars($pesananNama) ?></p>
        <?php endif; ?>


          <div id="order-summary" class="border-b pt-4">
            <div id="summary-items" class="space-y-2"></div>
          </div>

          <div class="flex justify-between items-center font-bold text-lg mt-4">
            <span>Total:</span>
            <span id="total-harga" class="text-blue-700">Rp0</span>
          </div>

          <div class="mt-auto pt-4 border-t border-gray-200">
            <button type="button" class="konfirmasi-btn bg-blue-700 text-white py-3 rounded-lg w-full">Konfirmasi</button>
          </div>
        </div>
      </div>
    </main>

    <div id="alertModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
      <div class="bg-white p-6 rounded-lg shadow-md max-w-sm text-center">
        <p id="alertMessage" class="text-gray-800 mb-4"></p>
        <button id="closeAlert" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">OK</button>
      </div>
    </div>
  </div>

  <script>
    const BASE_URL = "<?= $base_url ?>";
  </script>
  <script src="<?= $base_url ?>/script/order.js"></script>
</body>
</html>
