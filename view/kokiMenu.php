<?php
  require_once __DIR__ . '/../config.php';
  require_once __DIR__ . '/../src/kokiMenuDb.php';
  require_once __DIR__ . '/../src/middleware.php';
  requireRole('koki');
  $nama = $_SESSION['nama'] ?? $_SESSION['email'] ?? 'User';
  $role = $_SESSION['role'] ?? '-';
  $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>List Menu - MyResto</title>

  <link href="<?= $base_url ?>/output.css" rel="stylesheet" />
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
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
        <?php
          function navActive($path) {
              global $currentPath;
              return $currentPath === $path ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2';
          }
        ?>
        <a href="<?= $base_url ?>/list-pesanan" class="flex gap-3 py-2 font-semibold transition <?= navActive('/My-Resto/list-pesanan') ?>">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
          </svg>
          List Pesanan
        </a>
        <a href="<?= $base_url ?>/koki-menu" class="flex gap-3 py-2 font-semibold transition <?= navActive('/My-Resto/koki-menu') ?>">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
          List Menu
        </a>
      </div>
    </nav>

    <!-- Konten -->
    <main class="flex-grow flex justify-center p-6 gap-6">
        <!-- Search -->
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
            <button class="kategori-btn p-4 rounded-lg text-center font-semibold hover:border-1 hover:text-black text-gray-700 text-xl shadow-sm h-36 flex items-center justify-center <?= $bgClass ?>" data-kategori="<?= $row['id_kategori'] ?>">
              <?= $row['nama_kategori'] ?>
            </button>
          <?php endwhile; ?>
        </div>

        <hr class="border-t border-gray-200" />

        <!-- Menu -->
        <h1 class=" text-center text-2xl font-semibold">Menu</h1>
        <div class="flex justify-end gap-5">
          <button id="tambahMenuBtn" type="button" class="py-3 px-4 text-xl font-bold text-blue-200 bg-blue-600 rounded-md hover:bg-blue-700 shadow-lg transition">Tambah Menu</button>
        </div>
        <div id="menu-container" class="grid grid-cols-2 lg:grid-cols-4 gap-5 overflow-y-auto pr-2"></div>
      </div>
    </main>

    <div id="tambahMenuModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-opacity-50">
      <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md transform transition-all">
          <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Menu Baru</h2>
          <form action="<?=$base_url?>/src/kokiMenuPost.php" method="POST">
              <div class="mb-4">
                  <label for="nama_menu" class="block text-gray-700 font-semibold mb-2">Nama Menu</label>
                  <input type="text" id="nama_menu" name="nama" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
              </div>
              <div class="mb-4">
                  <label for="harga" class="block text-gray-700 font-semibold mb-2">Harga</label>
                  <input type="number" id="harga" name="harga" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" min="0" required>
              </div>
              <div class="mb-6">
                  <label for="id_kategori" class="block text-gray-700 font-semibold mb-2">Kategori</label>
                  <select id="id_kategori" name="id_kategori" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                      <option value="" disabled selected>Pilih Kategori</option>
                      <?php foreach ($kategori as $kat) : ?>
                          <option value="<?= htmlspecialchars($kat['id_kategori']) ?>"><?= htmlspecialchars($kat['nama_kategori']) ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <input type="hidden" name="status_ketersediaan" value="Tersedia">
              <div class="flex justify-end gap-4">
                  <button type="button" class="modal-close-btn py-2 px-6 bg-gray-300 text-gray-800 font-semibold rounded-md hover:bg-gray-400 transition">Batal</button>
                  <button type="submit" class="py-2 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">Simpan</button>
              </div>
          </form>
      </div>
    </div>

    <div id="konfirmasiHapusModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-opacity-60">
      <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-sm text-center transform transition-all">
          <h3 class="text-xl font-bold mb-4">Hapus Menu</h3>
          <p class="text-gray-600 mb-6">
              Apakah Anda yakin ingin menghapus menu <br> "<strong id="namaMenuHapus" class="text-red-600"></strong>"?
          </p>
          <form id="formHapusMenu" action="<?=$base_url?>/src/kokiMenuHapus.php" method="POST">
              <input type="hidden" name="id_menu" id="idMenuHapus">
              <div class="flex justify-center gap-4">
                  <button type="button" id="batalHapusBtn" class="py-2 px-6 bg-gray-300 text-gray-800 font-semibold rounded-md hover:bg-gray-400 transition">Batal</button>
                  <button type="submit" class="py-2 px-6 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition">Ya, Hapus</button>
              </div>
          </form>
      </div>
    </div>
    <div id="updateMenuModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-opacity-50">
      <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md transform transition-all">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Update Menu</h2>
        
        <form action="<?=$base_url?>/src/kokiMenuEdit.php" method="POST">
            <input type="hidden" name="action" value="update_menu">
            <input type="hidden" name="id_menu" id="update_id_menu">

            <div class="mb-4">
                <label for="update_nama_menu" class="block text-gray-700 font-semibold mb-2">Nama Menu</label>
                <input type="text" id="update_nama_menu" name="nama" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-6">
                <label for="update_harga" class="block text-gray-700 font-semibold mb-2">Harga</button>
                <input type="number" id="update_harga" name="harga" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" min="0" required>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" class="modal-close-btn py-2 px-6 bg-gray-300 text-gray-800 font-semibold rounded-md hover:bg-gray-400 transition">Batal</button>
                <button type="submit" class="py-2 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">Simpan Perubahan</button>
            </div>
        </form>
      </div>
    </div>
  </div>


  <!-- JS -->
  <script>
    const BASE_URL = "<?= $base_url ?>";
  </script>
  <script src="<?= $base_url ?>/script/kokiMenu.js"></script>
</body>
</html>
