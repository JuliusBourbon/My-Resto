<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koki - List Menu</title>
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
    <div>
        <div class="bg-white flex flex-col">
            <div class="">
                <div class="flex justify-between items-center px-7 text-black">
                    <img src="../img/myresto_icon.jpg" class="h-24 w-24">
                    <h1 class="font-semibold text-3xl">My Resto</h1>
                    <div class= "h-12 w-12 bg-blue-700 rounded-full">
                        <div class="hidden items-center space-x-4">
                            <ul>
                                <li><a href="">Profile</a></li>
                                <li><a href="">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="flex gap-7 items-center p-4 text-black ml-24">
                    <div>
                        <a href="">List Menu</a>
                    </div>
                    <div>
                        <a href="">List Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col items-center mt-10">
            <input type="text" placeholder="Search" class="w-3xl p-2 border border-gray-300 rounded-lg mt-4 mb-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
                <div class="bg-green-400 p-12 text-center hover:bg-green-600 rounded-lg shadow-md">
                    <h1>Sarapan</h1>
                </div>
                <div class="bg-yellow-400 p-12 text-center hover:bg-yellow-600 rounded-lg shadow-md">
                    <h1>Hidangan Utama</h1>
                </div>
                <div class="bg-blue-400 p-12 text-center hover:bg-blue-600 rounded-lg shadow-md">
                    <h1>Minuman</h1>
                </div>
                <div class="bg-pink-400 p-12 text-center hover:bg-pink-600 rounded-lg shadow-md">
                    <h1>Penutup</h1>
                </div>
            </div>

            <hr class="w-3/4 border-gray-300 my-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
                <div class="bg-green-400 p-12 text-center hover:bg-green-600 rounded-lg shadow-md">
                    <h1>Sarapan</h1>
                </div>
                <div class="bg-yellow-400 p-12 text-center hover:bg-yellow-600 rounded-lg shadow-md">
                    <h1>Hidangan Utama</h1>
                </div>
                <div class="bg-blue-400 p-12 text-center hover:bg-blue-600 rounded-lg shadow-md">
                    <h1>Minuman</h1>
                </div>
                <div class="bg-pink-400 p-12 text-center hover:bg-pink-600 rounded-lg shadow-md">
                    <h1>Penutup</h1>
                </div>
            </div>
        </div>
    </div>
</body>
</html>