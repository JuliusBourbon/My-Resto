<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/kokiMenuDb.php';

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
          <img src="<?= $base_url ?>/img/myresto_icon.jpg" alt="Logo" class="w-18 h-18 object-contain" />
        </div>
        <span class="text-2xl font-bold">MyResto</span>
        <div class="absolute right-10 top-1/2 -translate-y-1/2">
          <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center text-white">
            <i data-feather="user"></i>
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

    <!-- Konten -->
    <main class="flex-grow flex items-center justify-center p-6 gap-6">
      <div class="w-[65%] flex flex-col gap-6">
        <!-- Search -->
        <div class="relative">
          <i data-feather="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
          <input type="text" placeholder="Search" class="w-full bg-white pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Kategori -->
        <div class="grid grid-cols-4 gap-5">
          <?php while ($row = $kategori->fetch_assoc()) :
            $bgMap = [
              'Sarapan' => 'bg-[#C8F6BC]',
              'Hidangan Utama' => 'bg-[#FFD27E]',
              'Minuman' => 'bg-[#A2F9FF]',
              'Penutup' => 'bg-[#FEC0FF]'
            ];
            $bgClass = $bgMap[$row['nama_kategori']] ?? 'bg-gray-200';
          ?>
            <button class="kategori-btn p-4 rounded-lg text-center font-semibold text-gray-700 shadow-sm h-36 flex items-center justify-center <?= $bgClass ?>" data-kategori="<?= $row['id_kategori'] ?>">
              <?= $row['nama_kategori'] ?>
            </button>
          <?php endwhile; ?>
        </div>

        <hr class="border-t border-gray-200" />

        <!-- Menu -->
        <div id="menu-container" class="grid grid-cols-4 gap-5 overflow-y-auto pr-2"></div>
      </div>
    </main>
  </div>

  <!-- JS -->
  <script>
    let selectedKategori = null;

    function updateMenuContainer(data) {
      const container = document.querySelector('#menu-container');
      container.innerHTML = '';

      const bgMap = {
        'Sarapan': 'bg-[#C8F6BC]',
        'Hidangan Utama': 'bg-[#FFD27E]',
        'Minuman': 'bg-[#A2F9FF]',
        'Penutup': 'bg-[#FEC0FF]'
      };

      data.forEach(item => {
        const bg = bgMap[item.nama_kategori] || 'bg-gray-200';

        const el = document.createElement('div');
        el.className = `menu-item p-4 rounded-lg flex flex-col justify-between shadow-sm h-full ${bg}`;
        el.dataset.id_menu = item.id_menu;

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
    }

    function fetchMenu(kategoriId = null) {
      let url = "<?= $base_url ?>/src/menuFiltered.php";
      if (kategoriId) url += `?kategori_id=${kategoriId}`;

      fetch(url)
        .then(res => res.json())
        .then(data => {
          updateMenuContainer(data);
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
      fetchMenu();

      document.querySelectorAll('.kategori-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const kategoriId = btn.dataset.kategori;
          selectedKategori = selectedKategori === kategoriId ? null : kategoriId;
          fetchMenu(selectedKategori);
        });
      });
    });
  </script>
</body>
</html>
