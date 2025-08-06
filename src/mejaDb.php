<?php
require_once __DIR__ . '/connection.php';

$meja = $conn->query("SELECT * FROM meja WHERE nomor != 11");
$mejaTersedia = $conn->query("SELECT * FROM meja WHERE status = 'Tersedia'");
$meja11 = $conn->query("SELECT * FROM meja WHERE nomor = 11");

$counter = 1;
$counter11 = 1;

$tersedia = $conn->query("SELECT COUNT(*) AS total FROM meja WHERE status = 'Tersedia'")->fetch_assoc()['total'];
$penuh     = $conn->query("SELECT COUNT(*) AS total FROM meja WHERE status = 'Reserved'")->fetch_assoc()['total'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['meja'], $_POST['nama'], $_POST['jumlah'])) {
        $nomor_meja     = (int) $_POST['meja'];
        $nama_pelanggan = $conn->real_escape_string($_POST['nama']);
        $jumlah         = (int) $_POST['jumlah'];

        $result = $conn->query("SELECT id_meja FROM meja WHERE nomor = $nomor_meja LIMIT 1");
        if ($result && $row = $result->fetch_assoc()) {
            $id_meja = $row['id_meja'];

            $conn->query("INSERT INTO pesanan (id_meja, id_pelayan, waktu_pesan, status, nama, jumlah_pelanggan)
                          VALUES ($id_meja, 1, NOW(), 'Reservasi', '$nama_pelanggan', $jumlah)");

            $conn->query("UPDATE meja SET status = 'Reserved' WHERE id_meja = $id_meja");

            header("Location: /My-Resto/meja");
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nomor_meja'])) {
    header('Content-Type: application/json');
    $nomor_meja = (int) $_GET['nomor_meja'];

    $result = $conn->query("SELECT id_meja FROM meja WHERE nomor = $nomor_meja LIMIT 1");
    if ($result && $row = $result->fetch_assoc()) {
        $id_meja = $row['id_meja'];

        $pesanan = $conn->query("SELECT nama FROM pesanan WHERE id_meja = $id_meja AND status = 'Reservasi' ORDER BY waktu_pesan DESC LIMIT 1");

        if ($pesanan && $data = $pesanan->fetch_assoc()) {
            echo json_encode(['nama' => $data['nama']]);
        } else {
            echo json_encode(['nama' => '']);
        }
    } else {
        echo json_encode(['nama' => '']);
    }
}
