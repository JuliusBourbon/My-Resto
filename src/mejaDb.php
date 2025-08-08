<?php
require_once __DIR__ . '/connection.php';

$nama = $conn->query("SELECT nama FROM pesanan WHERE status != 'Served' AND status != 'Selesai'");
$meja = $conn->query("
    SELECT 
        m.id_meja, m.nomor, m.status, p.nama AS nama
    FROM 
        meja m
    LEFT JOIN 
        pesanan p ON m.id_meja = p.id_meja AND p.status != 'Selesai' AND p.status != 'Served' 
    WHERE 
        m.nomor != 11
    ORDER BY
        m.id_meja ASC
");
$mejaTersedia = $conn->query("SELECT * FROM meja WHERE status = 'Tersedia'");
$meja11 = $conn->query("SELECT * FROM meja WHERE nomor = 11");

$counter = 1;
$counter11 = 1;

$tersedia = $conn->query("SELECT COUNT(*) AS total FROM meja WHERE status = 'Tersedia'")->fetch_assoc()['total'];
$penuh     = $conn->query("SELECT COUNT(*) AS total FROM meja WHERE status = 'Reserved'")->fetch_assoc()['total'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_meja'], $_POST['nama'], $_POST['jumlah'])) {
        
        $id_meja        = (int) $_POST['id_meja'];
        $nama_pelanggan = $_POST['nama'];
        $jumlah         = (int) $_POST['jumlah'];

        if ($id_meja > 0) {
            $conn->begin_transaction();
            try {
                $stmtPesanan = $conn->prepare(
                    "INSERT INTO pesanan (id_meja, id_pelayan, waktu_pesan, status, nama, jumlah_pelanggan)
                     VALUES (?, 1, NOW(), 'Reservasi', ?, ?)"
                );
                $stmtPesanan->bind_param("isi", $id_meja, $nama_pelanggan, $jumlah);
                $stmtPesanan->execute();

                $stmtUpdateMeja = $conn->prepare("UPDATE meja SET status = 'Reserved' WHERE id_meja = ?");
                $stmtUpdateMeja->bind_param("i", $id_meja);
                $stmtUpdateMeja->execute();

                $conn->commit();
                
                header("Location: /My-Resto/meja"); 
                exit;

            } catch (Exception $e) {
                $conn->rollback();
                header("Location: /My-Resto/meja?error=1");
                exit;
            }
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
