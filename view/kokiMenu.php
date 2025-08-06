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
        <a href="<?= $base_url ?>/koki-menu" class="py-2 font-semibold transition <?= navActive('/My-Resto/koki-menu') ?>">List Menu</a>
        <a href="<?= $base_url ?>/list-pesanan" class="py-2 font-semibold transition <?= navActive('/My-Resto/list-pesanan') ?>">List Pesanan</a>
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
            <button class="kategori-btn p-4 rounded-lg text-center font-semibold hover:border-1 hover:text-black text-gray-700 text-xl shadow-sm h-36 flex items-center justify-center <?= $bgClass ?>" data-kategori="<?= $row['id_kategori'] ?>">
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
        el.className = `menu-item p-8 rounded-lg flex flex-col justify-between shadow-sm h-full ${bg}`;
        el.dataset.id_menu = item.id_menu;

        el.innerHTML = `
          <div class="flex flex-col items-center justify-center gap-2">
            <h3 class="font-bold text-gray-800 text-xl">${item.nama}</h3>
            <p class="text-lg text-gray-700 font-medium">Rp${parseInt(item.harga).toLocaleString('id-ID')}</p>
            <form method="POST" action="">
              <input type="hidden" name="id_menu" value="${item.id_menu}">
              <select name="status_ketersediaan" onchange="this.form.submit()" class="bg-white border border-gray-300 rounded px-2 py-1 text-md shadow hover:border-blue-400 transition focus:outline-none">
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

      document.querySelectorAll(".kategori-btn").forEach(btn => {
        btn.onclick = () => {
          const id = btn.dataset.kategori;
          const previouslySelected = selectedKategori;

          selectedKategori = selectedKategori === id ? null : id;

          document.querySelectorAll(".kategori-btn").forEach(b => {
            b.classList.remove("border-1", "text-black");
            b.classList.add("text-gray-700");
          });

          if (selectedKategori !== null) {
            btn.classList.add("border-1", "text-black");
            btn.classList.remove("text-gray-700");
          }

          fetchMenu(selectedKategori);
        };
      });
    });

    document.addEventListener("DOMContentLoaded", () => {
      const searchInput = document.getElementById('searchInput');
      const menuContainer = document.getElementById('menu-container');

      searchInput.addEventListener('input', () => {
          const searchTerm = searchInput.value.toLowerCase();
          const menuItems = menuContainer.querySelectorAll('.menu-item');

          menuItems.forEach(item => {
              const menuName = item.querySelector('h3').textContent.toLowerCase();

              if (menuName.includes(searchTerm)) {
                  item.style.display = 'flex'; 
              } else {
                  item.style.display = 'none'; 
              }
          });
      });

      document.querySelectorAll(".kategori-btn").forEach(btn => {
        btn.onclick = () => {
          const id = btn.dataset.kategori;
          const previouslySelected = selectedKategori;

          selectedKategori = selectedKategori === id ? null : id;

          document.querySelectorAll(".kategori-btn").forEach(b => {
            b.classList.remove("border-1", "text-black");
            b.classList.add("text-gray-700");
          });

          if (selectedKategori !== null) {
            btn.classList.add("border-1", "text-black");
            btn.classList.remove("text-gray-700");
          }

          fetchMenu(selectedKategori);
        };
      });
    });
  </script>
</body>
</html>
