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

if (isset($_GET['meja']) && $_GET['meja'] !== '') {
    $nomor_meja = (int) $_GET['meja'];

    $stmtMeja = $conn->prepare("SELECT id_meja FROM meja WHERE nomor = ? LIMIT 1");
    $stmtMeja->bind_param("i", $nomor_meja);
    $stmtMeja->execute();
    $resultMeja = $stmtMeja->get_result();

    if (isset($_GET['meja']) && $_GET['meja'] !== '') {
        // $_GET['meja'] sekarang adalah id_meja
        $id_meja = (int) $_GET['meja'];

        // Langsung gunakan $id_meja untuk query pesanan
        $stmtPesanan = $conn->prepare("
            SELECT nama 
            FROM pesanan 
            WHERE id_meja = ? AND status != 'Selesai' 
            ORDER BY waktu_pesan DESC 
            LIMIT 1
        ");
        $stmtPesanan->bind_param("i", $id_meja);
        $stmtPesanan->execute();
        $resultPesanan = $stmtPesanan->get_result();

        if ($resultPesanan && $data = $resultPesanan->fetch_assoc()) {
            $pesananNama = $data['nama'];
        }
    }
}