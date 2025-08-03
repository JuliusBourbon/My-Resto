<?php
    $currentPage = basename($_SERVER['PHP_SELF']); // ambil nama file saat ini
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
    </style>
    <link href="../output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Meja</title>
</head>
<body class="bg-gray-100 pt-[118px]">
    <div class="flex flex-col">
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
            <div class="w-full grid grid-cols-5 gap-5">
                <div class="w-full flex flex-col justify-center items-center">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                    <div class="w-full flex items-center justify-center gap-5">
                        <div class="w-30 h-30 rounded-full bg-gray-300 flex items-center justify-center">
                            <h1 class="text-center">1 <br> Tersedia</h1>
                        </div>
                    </div>
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col justify-center items-center">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                    <div class="w-full flex items-center justify-center gap-5">
                        <div class="w-30 h-30 rounded-full bg-gray-300 flex items-center justify-center">
                            <h1 class="text-center">1 <br> Tersedia</h1>
                        </div>
                    </div>
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col justify-center items-center">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                    <div class="w-full flex items-center justify-center gap-5">
                        <div class="w-30 h-30 rounded-full bg-gray-300 flex items-center justify-center">
                            <h1 class="text-center">1 <br> Tersedia</h1>
                        </div>
                    </div>
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col justify-center items-center">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                    <div class="w-full flex items-center justify-center gap-5">
                        <div class="w-30 h-30 rounded-full bg-gray-300 flex items-center justify-center">
                            <h1 class="text-center">1 <br> Tersedia</h1>
                        </div>
                    </div>
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col justify-center items-center">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                    <div class="w-full flex items-center justify-center gap-5">
                        <div class="w-30 h-30 rounded-full bg-gray-300 flex items-center justify-center">
                            <h1 class="text-center">1 <br> Tersedia</h1>
                        </div>
                    </div>
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col justify-center items-center">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                    <div class="w-full flex items-center justify-center gap-5">
                        <div class="w-30 h-30 rounded-full bg-gray-300 flex items-center justify-center">
                            <h1 class="text-center">1 <br> Tersedia</h1>
                        </div>
                    </div>
                    <div class="w-24 h-24 rounded-full flex items-center justify-center gap-5">
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                        <div class="w-8 h-8 bg-gray-300">
                            <h1></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center flex-col items-center mx-5">
                <div class="flex gap-5 items-center">
                    <div class="w-8 h-8 bg-gray-300">
                        <h1></h1>
                    </div>
                    <div class="w-15 h-15 bg-gray-300 flex items-center justify-center border-b-2 border-black-300">
                        <h1 class=" text-xl">11-1</h1>
                    </div>
                </div>
                <div class="flex gap-5 items-center">
                    <div class="w-8 h-8 bg-gray-300">
                        <h1></h1>
                    </div>
                    <div class="w-15 h-15 bg-gray-300 flex items-center justify-center border-b-2 border-black-300">
                        <h1 class=" text-xl">11-2</h1>
                    </div>
                </div>
                <div class="flex gap-5 items-center">
                    <div class="w-8 h-8 bg-gray-300">
                        <h1></h1>
                    </div>
                    <div class="w-15 h-15 bg-gray-300 flex items-center justify-center border-b-2 border-black-300">
                        <h1 class=" text-xl">11-3</h1>
                    </div>
                </div>
                <div class="flex gap-5 items-center">
                    <div class="w-8 h-8 bg-gray-300">
                        <h1></h1>
                    </div>
                    <div class="w-15 h-15 bg-gray-300 flex items-center justify-center border-b-2 border-black-300">
                        <h1 class=" text-xl">11-4</h1>
                    </div>
                </div>
                <div class="flex gap-5 items-center">
                    <div class="w-8 h-8 bg-gray-300">
                        <h1></h1>
                    </div>
                    <div class="w-15 h-15 bg-gray-300 flex items-center justify-center border-b-2 border-black-300">
                        <h1 class=" text-xl">11-5</h1>
                    </div>
                </div>
                <div class="flex gap-5 items-center">
                    <div class="w-8 h-8 bg-gray-300">
                        <h1></h1>
                    </div>
                    <div class="w-15 h-15 bg-gray-300 flex items-center justify-center border-b-2 border-black-300">
                        <h1 class=" text-xl">11-6</h1>
                    </div>
                </div>
                <div class="flex gap-5 items-center">
                    <div class="w-8 h-8 bg-gray-300">
                        <h1></h1>
                    </div>
                    <div class="w-15 h-15 bg-gray-300 flex items-center justify-center border-b-2 border-black-300">
                        <h1 class=" text-xl">11-7</h1>
                    </div>
                </div>
                <div class="flex gap-5 items-center">
                    <div class="w-8 h-8 bg-gray-300">
                        <h1></h1>
                    </div>
                    <div class="w-15 h-15 bg-gray-300 flex items-center justify-center">
                        <h1 class=" text-xl">11-8</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 z-50 px-10 py-4 bg-white border-t border-gray-200">
            <div class="flex justify-between w-full bg-white h-30 items-center">
                <div class="mx-10 flex flex-col gap-5">
                    <h1>Meja Tersedia: </h1>
                    <h1>Meja Penuh: </h1>
                </div>
    
                <div class="flex items-center">
                    <input type="button" value="Reservasi" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-800 transition duration-200">
                </div>
            </div>
        </div>
    </div>
</body>
</html>