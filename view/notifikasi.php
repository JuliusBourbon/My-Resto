<?php
    $currentPage = basename($_SERVER['PHP_SELF']); // ambil nama file saat ini
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        </style>
    <link href="../output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">
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
        
        <div class="flex items-center justify-center h-screen">
            <div class="w-10/12 bg-white shadow-md rounded-lg mt-20">
                <!-- Header Tabs -->
                <div class="flex items-center justify-between overflow-hidden">
                    <button id="pendingTab" class="text-xl bg-blue-400 w-1/2 text-center py-2 rounded-tl-lg font-semibold text-gray-800">Pending</button>
                    <button id="confirmBtn" class="text-xl bg-blue-300 w-1/2 text-center py-2 rounded-tr-lg font-semibold text-gray-600">Terkonfirmasi</button>
                </div>
                
                <!-- Pending Section -->
                <div id="pendingSection" class="flex p-8 justify-center">
                    <div class="border-2 border-gray-300 rounded-md px-5 py-4 flex items-center justify-between w-full">
                        <div class="flex justify-between gap-4 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022
                            c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        <h1 class="text-2xl font-semibold">Order 5 Siap disajikan</h1>
                    </div>
                    <div class="flex rounded-md">
                        <input type="button" value="X"
                        class="border border-gray-500 bg-red-300 text-black px-10 py-2 rounded-l-md cursor-pointer hover:bg-red-500 transition">
                        <input type="button" value="✓" id=""
                        class="border border-gray-500 bg-green-300 text-black px-10 py-2 rounded-r-md cursor-pointer hover:bg-green-500 transition">
                    </div>
                </div>
            </div>
            
            <!-- Confirmed Section -->
            <div id="confirmedSection" class="hidden p-8 justify-center">
                <div class="border-2 border-green-400 rounded-md px-5 py-4 w-full text-center">
                    <h1 class="text-2xl font-semibold text-green-600">Order 5 telah dikonfirmasi ✅</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../script/notifikasi.js"></script>
</body>
</html>

