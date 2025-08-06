<?php
    session_start();
    require_once __DIR__ . '/../config.php'; 
    $pageTitle = "Login - My Resto";
    $currentYear = date('Y'); 
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>/output.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:ital,wght@0,200..900&family=Inter:ital,wght@0,100..900&family=Manrope:wght@200..800&family=Merriweather:ital,wght@0,300..900&family=Poppins:ital,wght@0,100..900&display=swap" rel="stylesheet">
</head>
<body class="font-sans bg-white w-screen h-screen overflow-hidden">
    <div class="flex flex-col md:flex-row w-screen h-screen">

        <!-- Form Section -->
        <div class="w-full md:w-1/2 flex justify-center items-center relative">
            <div class="w-full max-w-md">

                <!-- Logo -->
                <div class="flex justify-center items-center mb-24">
                    <img src="<?= $base_url ?>/img/myresto_icon.jpg" alt="My Resto Logo" class="h-1/2 w-1/2">
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Login</h1>
                    <p class="text-gray-500">Selamat datang di MyResto<br>Sistem Pelayanan Restoran Unikom</p>
                </div>

                <!-- Form -->
                <form action="<?= $base_url ?>/src/loginDb.php" method="POST">
                    <!-- Username -->
                    <div class="relative mb-5">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <!-- User icon -->
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="2" d="M12 2a5 5 0 015 5v0a5 5 0 01-10 0v0a5 5 0 015-5zM3.41 22a9 9 0 0117.18 0"/>
                            </svg>
                        </div>
                        <input type="text" id="username" name="email" placeholder="Username" required
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    <!-- Password -->
                    <div class="relative mb-6">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <!-- Lock icon -->
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <rect x="5" y="11" width="14" height="10" rx="2" stroke-width="2"/>
                                <path d="M7 11V7a5 5 0 0110 0v4" stroke-width="2"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Password" required
                            class="w-full pl-12 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        
                        <!-- Toggle password icon -->
                        <div id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer">
                            <!-- Eye open icon -->
                            <svg id="eye-icon" class="block" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <!-- Eye slashed icon -->
                            <svg id="eye-slashed-icon" class="hidden" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M17.94 17.94A11.952 11.952 0 0112 20c-7 0-11-8-11-8s2.29-4.81 5.86-6.36M9.88 9.88A3 3 0 0012 15a3 3 0 002.12-5.12M23 12s-2.27 4.85-5.06 5.94M12 4a11.952 11.952 0 015.94 2.06L23 1M1 23L23 1"/>
                            </svg>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Login
                    </button>
                </form>

                <!-- Footer -->
                <div class="text-center text-gray-500 text-sm absolute bottom-5 left-0 right-0">
                    <p>Tari Reog <?= htmlspecialchars($currentYear) ?></p>
                </div>
            </div>
        </div>

        <!-- Background Image -->
        <div class="w-full md:w-1/2 flex justify-center items-center relative">
            <img src="<?= $base_url ?>/img/login_bg.png" alt="" class="w-full h-full object-cover">
        </div>
    </div>

    <!-- JS -->
    <script src="<?= $base_url ?>/script/login.js"></script>
</body>
</html>
