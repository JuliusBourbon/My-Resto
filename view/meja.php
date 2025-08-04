<?php
    $currentPage = basename($_SERVER['PHP_SELF']); // ambil nama file saat ini
    require('../src/mejaDb.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link href="../output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Meja</title>
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
                    <a href="meja.php" class="py-2 font-semibold transition <?= $currentPage === 'meja.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">Meja</a>
                </div>
                <div class="flex items-center gap-6 pt-1">
                    <a href="order.php" class="py-2 font-semibold transition <?= $currentPage === 'order.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">Pesanan</a>
                </div>
                <div class="flex items-center gap-6 pt-1">
                    <a href="notifikasi.php" class="py-2 font-semibold transition<?= $currentPage === 'notifikasi.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">Notifikasi</a>
                </div>
            </div>
        </nav>

        <div class="flex items-center">
            <!-- <div class=""> -->
            <div class="flex flex-col gap-30">
                <h1 class="bg-gray-300 py-2 px-5 rotate-[-90deg]">Kasir</h1>
                <h1 class="bg-gray-300 py-2 px-5 rotate-[-90deg]">Pintu</h1>
            </div>
            <!-- </div> -->
            <div class="w-full grid grid-cols-5 gap-5 p-4">
                <?php while ($row = $meja->fetch_assoc()) : ?>
                    <div class="w-full flex flex-col justify-center items-center">
                        <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        </div>

                        <div class="w-full flex items-center justify-center gap-5">
                            <div class="w-30 h-30 rounded-full flex items-center justify-center
                                <?php echo $row['status'] === 'Tersedia' ? 'bg-green-300' : 'bg-red-400'; ?>">
                                <h1 class="text-center">
                                    <?=$row['nomor']?> <br> <?=$row['status']?>
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
                        <div class="w-15 h-15 flex items-center justify-center border-b-2 border-black-300
                            <?= $row['status'] === 'Reserved' ? 'bg-red-400' : 'bg-gray-300' ?>">
                            <h1 class="text-xl">11-<?= $counter ?></h1>
                        </div>
                    </div>
                    <?php $counter++; ?>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 z-50 px-10 py-4 bg-white border-t border-gray-200">
            <div class="flex justify-between w-full bg-white h-30 items-center">
                <div class="mx-10 flex flex-col gap-5">
                    <h1>Meja Tersedia: <?= $tersedia?></h1>
                    <h1>Meja Penuh: <?= $penuh?></h1>
                </div>
    
                <div class="flex items-center">
                    <input type="button" id="Reservasi" value="Reservasi" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-800 transition duration-200">
                </div>
            </div>
        </div>
    </div>

    <div class="fixed top-0 left-0 right-0 z-50 flex justify-center items-center h-screen hidden" id="reservasiModal">
        <div class="flex justify-center items-center shadow-md rounded-md bg-white w-1/3">
            <div class="flex flex-col items-center p-6">
                <h1 class="text-2xl font-semibold mb-4">Reservasi</h1>
                <form action="../src/mejaDb.php" method="POST" class="w-full">
                    <h1 class="mb-2">No. Meja</h1>
                    <select name="meja" class="w-full p-2 mb-4 border rounded" required>
                        <?php while ($row = $mejaTersedia->fetch_assoc()) : ?>
                            <?php
                                // Khusus meja nomor 11, beri label 11-1, 11-2, ...
                                if ($row['nomor'] == 11) {
                                    $label = '11-' . $counter11;
                                    $counter11++;
                                } else {
                                    $label = $row['nomor'];
                                }
                            ?>
                            <option value="<?= $row['nomor'] ?>"><?= $label ?></option>
                        <?php endwhile; ?>
                    </select>

                    <h1 class="mb-2">Nama Pelanggan</h1>
                    <input type="text" name="nama" placeholder="Nama Pelanggan" class="w-full p-2 mb-4 border rounded" required>

                    <h1 class="mb-2">Jumlah Pelanggan</h1>
                    <div class="flex justify-between items-center gap-2 mb-4">
                        <input type="button" value="1" class="btn-jumlah border text-xl rounded-sm w-1/6 bg-gray-300 cursor-pointer hover:bg-gray-400">
                        <input type="button" value="2" class="btn-jumlah border text-xl rounded-sm w-1/6 bg-gray-300 cursor-pointer hover:bg-gray-400">
                        <input type="button" value="3" class="btn-jumlah border text-xl rounded-sm w-1/6 bg-gray-300 cursor-pointer hover:bg-gray-400">
                        <input type="number" id="jumlahCustom" placeholder="Custom" class="text-xl text-center border rounded-sm w-1/3 bg-gray-100" min="1">
                    </div>

                    <!-- hidden input untuk dikirim ke PHP -->
                    <input type="hidden" name="jumlah" id="jumlahInput" required>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-800 transition duration-200 w-full">
                        Reservasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    document.getElementById('Reservasi').addEventListener('click', function () {
        document.getElementById('reservasiModal').classList.remove('hidden');
        document.getElementById('main').classList.add('blur-sm');
    });

    // Tutup modal jika klik di luar isi modal
    window.addEventListener('click', function (event) {
        const modal = document.getElementById('reservasiModal');
        const modalContent = modal.querySelector('div');

        if (event.target === modal) {
            modal.classList.add('hidden');
            main.classList.remove('blur-sm');
        }
    });

    const jumlahButtons = document.querySelectorAll('.btn-jumlah');
    const jumlahInput = document.getElementById('jumlahInput');
    const jumlahCustom = document.getElementById('jumlahCustom');

    jumlahButtons.forEach(button => {
        button.addEventListener('click', () => {
            jumlahInput.value = button.value;
            jumlahCustom.value = ''; // kosongkan custom jika tombol dipilih
        });
    });

    jumlahCustom.addEventListener('input', () => {
        jumlahInput.value = jumlahCustom.value;
    });
</script>
</html>