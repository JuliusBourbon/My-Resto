<?php
$project_location = "/My-Resto"; 
$me = $project_location;

// Ambil path dari URL
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routing
switch ($request) {
    case $me.'/' :
    case $me.'/index' :
        require __DIR__ . '/view/index.php';
        break;

    case $me.'/login' :
        require __DIR__ . '/view/login.php';
        break;

    case $me.'/order' :
        require __DIR__ . '/view/order.php';
        break;

    case $me.'/meja' :
        require __DIR__ . '/view/meja.php';
        break;

    case $me.'/list-pesanan' :
        require __DIR__ . '/view/listPesanan.php';
        break;

    case $me.'/koki-menu' :
        require __DIR__ . '/view/kokiMenu.php';
        break;

    case $me.'/pembayaran' :
        require __DIR__ . '/view/pembayaran.php';
        break;
    
    case $me.'/histori' :
        require __DIR__ . '/view/histori.php';
    break;

    case $me.'/notifikasi' :
        require __DIR__ . '/view/notifikasi.php';
        break;

    case $me.'/logout' :
        require __DIR__ . '/src/logout.php';
        break;

    default:
        http_response_code(404);
        echo "404 - Halaman Tidak Ditemukan";
        break;
}
