<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pesanan</title>
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
                    <a href="kokiMenu.php" class="py-2 font-semibold transition <?= $currentPage === 'kokiMenu.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">List Menu</a>
                </div>
                <div class="flex items-center gap-6 pt-1">
                    <a href="listPesanan.php" class="py-2 font-semibold transition <?= $currentPage === 'listPesanan.php' ? 'text-blue-700 border-b-2 border-blue-700' : 'text-gray-500 hover:border-b-2' ?>">List Pesanan</a>
                </div>
            </div>
        </nav>

        <div class="flex justify-center gap-10">
            <div class="w-1/6 flex justify-center flex-col items-center bg-white shadow-md rounded-lg mt-6 ">
                <h1 class="text-2xl font-semibold mt-5">Jumlah Antrian</h1>
                <h1 class="text-3xl font-semibold my-10">5</h1>
            </div>

            <div class="w-1/6 flex justify-center flex-col items-center bg-white shadow-md rounded-lg mt-6 ">
                <h1 class="text-2xl font-semibold mt-5">Pesanan Selesai</h1>
                <h1 class="text-3xl font-semibold my-10">5</h1>
            </div>

            <div class="w-1/6 flex justify-center flex-col items-center bg-white shadow-md rounded-lg mt-6 ">
                <h1 class="text-2xl font-semibold mt-5">Pesanan Batal</h1>
                <h1 class="text-3xl font-semibold my-10">5</h1>
            </div>
        </div>

        <div class="flex justify-center mt-10 mx-15 bg-white shadow-md rounded-lg p-6">
            <table class="w-full text-center m-10">
                <thead>
                    <tr class="">
                        <th class="py-2">No</th>
                        <th class="py-2">Order</th>
                        <th class="py-2">Pesanan</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border py-2">1</td>
                        <td class="border py-2">Order 1</td>
                        <td class="border py-2"><input type="button" value="Detail" class="border rounded-sm w-1/2 bg-gray-300"></td>
                        <td class="border py-2"><select name="" id="" class="border bg-gray-300 w-1/2 text-center rounded-sm">
                            <option value="antri">Ready to Serve</option>
                            <option value="selesai">Preparing</option>
                            <option value="batal">Canceled</option>
                        </select></td>
                        <td class="border py-2"><input type="button" value="Detail" class="border rounded-sm w-3/4 bg-gray-300"></td>
                    </tr>
                    <tr>
                        <td class="border py-2">2</td>
                        <td class="border py-2">Order 2</td>
                        <td class="border py-2"><input type="button" value="Detail" class="border rounded-sm w-1/2 bg-gray-300"></td>
                        <td class="border py-2"><select name="" id="" class="border bg-gray-300 w-1/2 text-center rounded-sm">
                            <option value="antri">Ready to Serve</option>
                            <option value="selesai">Preparing</option>
                            <option value="batal">Canceled</option>
                        </select></td>
                        <td class="border py-2"><input type="button" value="Detail" class="border rounded-sm w-3/4 bg-gray-300"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</body>
</html>