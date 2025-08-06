<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/pesananDb.php';

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
        <div class="flex items-center gap-6 pt-1">
            <a href="<?= $base_url ?>/meja"
            class="py-2 font-semibold transition <?= $currentPath === '/My-Resto/meja' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
            Meja
            </a>
        </div>
        <div class="flex items-center gap-6 pt-1">
            <a href="<?= $base_url ?>/order"
            class="py-2 font-semibold transition <?= $currentPath === '/My-Resto/order' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
            Pesanan
            </a>
        </div>
        <div class="flex items-center gap-6 pt-1">
            <a href="<?= $base_url ?>/notifikasi"
            class="py-2 font-semibold transition <?= $currentPath === '/My-Resto/notifikasi' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">
            Notifikasi
            </a>
        </div>
    </div>

    <!-- Konten -->
    <main class="flex-grow flex p-6 gap-6">
      <!-- Kiri: Menu -->
      <div class="w-[65%] flex flex-col gap-6">
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

        <!-- Daftar Menu -->
        <div id="menu-container" class="grid grid-cols-4 gap-5 overflow-y-auto pr-2"></div>
      </div>

      <!-- Kanan: Ringkasan Order -->
      <div class="w-[35%] flex justify-center items-start pt-10">
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col w-full max-w-sm">
          <form method="GET" class="w-full flex flex-col">
            <label class="block font-semibold mb-2 text-center">Pilih Meja</label>
            <select name="meja" class="w-full p-2 mb-4 border rounded" onchange="this.form.submit()" required>
              <option value="">-- Pilih Meja --</option>
              <?php
              $counter11 = 1;
              while ($row = $mejaReserved->fetch_assoc()) :
                $label = $row['nomor'] == 11 ? '11-' . $counter11++ : $row['nomor'];
                $selected = isset($_GET['meja']) && $_GET['meja'] == $row['nomor'] ? 'selected' : '';
              ?>
              <option value="<?= $row['nomor'] ?>" <?= $selected ?>>Meja <?= $label ?></option>
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
  </div>

  <!-- Script -->
  <script>
    let selectedQuantities = {};
    let allMenuItems = {};
    let selectedKategori = null;

    function updateOrderSummary() {
      const container = document.getElementById("summary-items");
      const totalEl = document.getElementById("total-harga");
      container.innerHTML = '';
      let total = 0;

      for (const id in selectedQuantities) {
        const qty = selectedQuantities[id];
        if (qty > 0) {
          const item = allMenuItems[id];
          const subtotal = item.harga * qty;
          total += subtotal;
          container.innerHTML += `
            <div class="flex justify-between"><span>${item.nama} x ${qty}</span><span>Rp${subtotal.toLocaleString('id-ID')}</span></div>
          `;
        }
      }

      totalEl.textContent = 'Rp' + total.toLocaleString('id-ID');
    }

    function bindQuantityButtons() {
      document.querySelectorAll(".quantity-btn").forEach(btn => {
        btn.onclick = () => {
          const input = btn.parentElement.querySelector(".quantity");
          const id = btn.closest(".menu-item").dataset.id_menu;
          let val = parseInt(input.value);
          val = btn.classList.contains("plus") ? val + 1 : Math.max(val - 1, 0);
          input.value = val;
          selectedQuantities[id] = val;
          updateOrderSummary();
        };
      });
    }

    function updateMenu(data) {
      const container = document.getElementById("menu-container");
      container.innerHTML = '';
      data.forEach(item => {
        allMenuItems[item.id_menu] = { nama: item.nama, harga: parseInt(item.harga) };
        const qty = selectedQuantities[item.id_menu] || 0;
        const bgMap = {
          'Sarapan': 'bg-[#C8F6BC]', 'Hidangan Utama': 'bg-[#FFD27E]',
          'Minuman': 'bg-[#A2F9FF]', 'Penutup': 'bg-[#FEC0FF]'
        };
        const bg = item.status_ketersediaan === 'Tersedia' ? (bgMap[item.nama_kategori] || 'bg-gray-200') : 'opacity-60 bg-gray-300';
        container.innerHTML += `
          <div class="menu-item p-4 rounded-lg flex flex-col justify-between shadow-sm h-36 ${bg}" data-id_menu="${item.id_menu}">
            <div class="flex-grow"><h3 class="font-bold">${item.nama}</h3><p>Rp${item.harga}</p></div>
            ${item.status_ketersediaan === 'Tersedia' ? `
              <div class="flex items-center justify-center gap-2 mt-2">
                <button class="quantity-btn minus bg-white p-1 rounded w-7 h-7">-</button>
                <input class="quantity text-center w-10" value="${qty}" min="0">
                <button class="quantity-btn plus bg-white p-1 rounded w-7 h-7">+</button>
              </div>
            ` : `<p class="text-center mt-4 font-bold text-gray-600">Tidak Tersedia</p>`}
          </div>
        `;
      });
      bindQuantityButtons();
    }

    function fetchMenu(kategoriId = null) {
      let url = "<?= $base_url ?>/src/menuFiltered.php";
      if (kategoriId) url += "?kategori_id=" + kategoriId;
      fetch(url).then(res => res.json()).then(data => {
        updateMenu(data);
        updateOrderSummary();
      });
    }

    document.addEventListener("DOMContentLoaded", () => {
      fetchMenu();

      document.querySelectorAll(".kategori-btn").forEach(btn => {
        btn.onclick = () => {
          const id = btn.dataset.kategori;
          selectedKategori = selectedKategori === id ? null : id;
          fetchMenu(selectedKategori);
        };
      });

      document.querySelector(".konfirmasi-btn").onclick = () => {
        const nomorMeja = document.querySelector("select[name='meja']").value;
        if (!nomorMeja) return alert("Pilih meja terlebih dahulu.");

        const pesanan = Object.entries(selectedQuantities)
          .filter(([, qty]) => qty > 0)
          .map(([id_menu, jumlah]) => ({ id_menu: parseInt(id_menu), jumlah }));

        if (pesanan.length === 0) return alert("Pesanan kosong.");

        fetch("<?= $base_url ?>/src/submitPesanan.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ nomor_meja: parseInt(nomorMeja), pesanan })
        })
        .then(res => res.json())
        .then(res => {
          if (res.success) {
            alert("Pesanan berhasil!");
            window.location.reload();
          } else {
            alert("Gagal menyimpan: " + res.message);
          }
        });
      };
    });
  </script>
</body>
</html>
