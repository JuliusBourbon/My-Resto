<?php

require_once __DIR__ . '/connection.php';

$pendingOrders = [];

$queryPending = $conn->query("
    SELECT 
        p.id_pesanan, 
        m.nomor AS nomor_meja, 
        p.nama AS nama_pelanggan, 
        p.status, 
        p.waktu_pesan
    FROM pesanan p
    JOIN meja m ON p.id_meja = m.id_meja
    WHERE p.status = 'Pending'
    ORDER BY p.waktu_pesan ASC
");

if ($queryPending) {
    while ($row = $queryPending->fetch_assoc()) {
        $pendingOrders[] = $row;
    }
}

$confirmedOrders = [];

$queryConfirmed = $conn->query("
    SELECT 
        p.id_pesanan, 
        m.nomor AS nomor_meja, 
        p.nama AS nama_pelanggan, 
        p.status, 
        p.waktu_pesan
    FROM pesanan p
    JOIN meja m ON p.id_meja = m.id_meja
    WHERE p.status IN ('Preparing', 'Ready To Serve')
    ORDER BY p.waktu_pesan ASC
");

if ($queryConfirmed) {
    while ($row = $queryConfirmed->fetch_assoc()) {
        $confirmedOrders[] = $row;
    }
}

$jumlahPreparing = 0;
$jumlahReady     = 0;

$queryPreparing = $conn->query("SELECT COUNT(id_pesanan) AS total FROM pesanan WHERE status = 'Preparing'");
if ($queryPreparing) {
    $jumlahPreparing = $queryPreparing->fetch_assoc()['total'] ?? 0;
}

$queryReady = $conn->query("SELECT COUNT(id_pesanan) AS total FROM pesanan WHERE status = 'Ready To Serve'");
if ($queryReady) {
    $jumlahReady = $queryReady->fetch_assoc()['total'] ?? 0;
}

$semuaDetailPesanan = [];

$queryDetail = $conn->query("
    SELECT dt.id_pesanan, m.nama AS nama_menu, dt.jumlah
    FROM detail_transaksi dt
    JOIN menu m ON dt.id_menu = m.id_menu
");

if ($queryDetail) {
    while ($row = $queryDetail->fetch_assoc()) {
        $semuaDetailPesanan[$row['id_pesanan']][] = [
            'nama_menu' => $row['nama_menu'],
            'jumlah'    => $row['jumlah']
        ];
    }
}

$conn->close();
