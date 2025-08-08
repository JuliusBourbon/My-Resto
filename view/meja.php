<?php
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../src/mejaDb.php';
    require_once __DIR__ . '/../src/middleware.php';
    requireRole('pelayan');
    $currentPage = basename($_SERVER['PHP_SELF']);
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $nama = $_SESSION['nama'] ?? $_SESSION['email'] ?? 'User';
    $role = $_SESSION['role'] ?? '-';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Meja</title>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    input[type=number] {
      -moz-appearance: textfield;
      appearance: textfield;
    }
  </style>

  <link href="<?= $base_url ?>/output.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed&family=Inter&family=Manrope:wght@200..800&family=Merriweather&family=Poppins&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 pt-[118px]">
  <div id="main" class="flex flex-col">

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


    <!-- Layout Meja -->
    <div class="flex items-center">
      <div class="flex flex-col gap-30">
        <h1 class="bg-gray-300 py-2 px-5 rotate-[-90deg]">Kasir</h1>
        <h1 class="bg-gray-300 py-2 px-5 rotate-[-90deg]">Pintu</h1>
      </div>

      <div class="w-full grid grid-cols-5 gap-5 p-4">
        <?php while ($row = $meja->fetch_assoc()) : ?>
          <div class="w-full flex flex-col justify-center items-center">
            <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
              <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
              <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
            </div>

            <div class="w-full flex items-center justify-center gap-5">
              <div class="w-30 h-30 rounded-full flex items-center justify-center <?= $row['status'] === 'Tersedia' ? 'bg-green-300' : 'bg-red-400'; ?>">
                <h1 class="text-center">
                  <?= $row['nomor'] ?> <br> 
                  <?= $row['status'] ?> <br> 
                  <?php if (!empty($row['nama'])) : ?>
                    by
                    <div class="text-white font-semibold">
                        <?php
                        $nama_lengkap = $row['nama'];
                        
                        // Cek jika panjang nama lebih dari 7 karakter
                        if (strlen($nama_lengkap) > 7) {
                            // Ambil 7 karakter pertama, lalu tambahkan "..."
                            $nama_tampil = substr($nama_lengkap, 0, 7) . '...';
                        } else {
                            // Jika tidak, tampilkan nama lengkap
                            $nama_tampil = $nama_lengkap;
                        }
                        
                        echo htmlspecialchars($nama_tampil);
                        ?>
                    </div>
                  <?php endif; ?>
                </h1>
              </div>
            </div>

            <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
              <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
              <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <div class="flex justify-center flex-col items-center mx-5">
        <?php while ($row = $meja11->fetch_assoc()) : ?>
          <div class="flex gap-5 items-center mb-2">
            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
            <div class="w-15 h-15 flex items-center justify-center border-b-2 border-black-300 <?= $row['status'] === 'Reserved' ? 'bg-red-400' : 'bg-gray-300' ?>">
              <h1 class="text-xl">11-<?= $counter ?></h1>
            </div>
          </div>
          <?php $counter++; ?>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- Footer / Reservasi -->
    <div class="fixed bottom-0 left-0 right-0 z-50 px-10 py-4 bg-white border-t border-gray-200">
      <div class="flex justify-between w-full bg-white h-30 items-center">
        <div class="mx-10 flex flex-col gap-5">
          <h1>Meja Tersedia: <?= $tersedia ?></h1>
          <h1>Meja Penuh: <?= $penuh ?></h1>
        </div>

        <div class="flex items-center">
          <input type="button" id="Reservasi" value="Reservasi" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-800 transition duration-200">
        </div>
      </div>
    </div>
  </div>

  <!-- Reservasi Modal -->
  <div class="fixed top-0 left-0 right-0 z-50 flex justify-center items-center h-screen hidden" id="reservasiModal">
    <div class="flex justify-center items-center shadow-md rounded-md bg-white w-1/3">
      <div class="flex flex-col items-center p-6 w-3/4">
        <h1 class="text-2xl font-semibold mb-4">Reservasi</h1>
        <form action="<?= $base_url ?>/src/mejaDb.php" method="POST" class="w-full">
          <h1 class="mb-2">No. Meja</h1>
          <select name="id_meja" id="id_meja" class="w-full p-2 mb-4 border rounded" required>
            <option value="">Pilih Meja Tersedia</option>
            <?php
            $semuaMeja11Query = $conn->query("SELECT id_meja FROM meja WHERE nomor = 11 ORDER BY id_meja ASC");
            $petaIdKeSubNomor = [];
            $subNomorCounter = 1;
            while ($meja11 = $semuaMeja11Query->fetch_assoc()) {
                $petaIdKeSubNomor[$meja11['id_meja']] = $subNomorCounter++;
            }

            $mejaTersedia = $conn->query("SELECT * FROM meja WHERE status = 'Tersedia' ORDER BY id_meja ASC");
            
            while ($row = $mejaTersedia->fetch_assoc()) :
                $label = $row['nomor'];

                if ($row['nomor'] == 11) {
                    if (isset($petaIdKeSubNomor[$row['id_meja']])) {
                        $subNomor = $petaIdKeSubNomor[$row['id_meja']];
                        $label = '11-' . $subNomor;
                    }
                }
            ?>
                <option value="<?= $row['id_meja'] ?>" data-nomor="<?= $row['nomor'] ?>"> <?= htmlspecialchars($label) ?></option>
            <?php endwhile; ?>
          </select>

          <h1 class="mb-2">Nama Pelanggan</h1>
          <input type="text" name="nama" placeholder="Nama Pelanggan" class="w-full p-2 mb-4 border rounded" required>

          <h1 id="judul-jumlah" class="mb-2">Jumlah Pelanggan</h1>
          <div id="container-jumlah" class="flex justify-between items-center mb-4">
            <input type="button" value="1" class="btn-jumlah border text-xl rounded-sm w-1/6 bg-gray-300 cursor-pointer hover:bg-gray-400">
            <input type="button" value="2" class="btn-jumlah border text-xl rounded-sm w-1/6 bg-gray-300 cursor-pointer hover:bg-gray-400">
            <input type="button" value="3" class="btn-jumlah border text-xl rounded-sm w-1/6 bg-gray-300 cursor-pointer hover:bg-gray-400">
            <input type="button" value="4" class="btn-jumlah border text-xl rounded-sm w-1/6 bg-gray-300 cursor-pointer hover:bg-gray-400">
          </div>

          <input type="hidden" name="jumlah" id="jumlahValue" value="1" required>

          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-800 transition duration-200 w-full">
            Reservasi
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="<?= $base_url ?>/script/meja.js"></script>
</body>
</html>
