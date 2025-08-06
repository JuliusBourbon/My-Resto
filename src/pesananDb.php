<?php
require_once __DIR__ . '/connection.php';

// Ambil semua kategori
$kategori = $conn->query("SELECT * FROM kategori_menu");

// Ambil semua menu dengan nama kategori
$menu = $conn->query("
    SELECT m.*, k.nama_kategori 
    FROM menu m 
    JOIN kategori_menu k ON m.id_kategori = k.id_kategori
");

// Ambil meja yang sudah direservasi
$mejaReserved = $conn->query("SELECT * FROM meja WHERE status = 'Reserved'");

$counter11 = 1;
$pesananNama = null;

// Ambil nama pelanggan berdasarkan nomor meja (via ?meja=...)
if (isset($_GET['meja']) && $_GET['meja'] !== '') {
    $nomor_meja = (int) $_GET['meja'];

    // Cari id_meja dari nomor meja
    $result = $conn->query("SELECT id_meja FROM meja WHERE nomor = $nomor_meja LIMIT 1");
    if ($result && $row = $result->fetch_assoc()) {
        $id_meja = $row['id_meja'];

        // Cari pesanan dengan status 'Reservasi' pada meja tersebut
        $queryPesanan = $conn->query("
            SELECT nama 
            FROM pesanan 
            WHERE id_meja = $id_meja 
              AND status = 'Reservasi' 
            ORDER BY waktu_pesan DESC 
            LIMIT 1
        ");

        if ($queryPesanan && $data = $queryPesanan->fetch_assoc()) {
            $pesananNama = $data['nama'];
        }
    }
}
