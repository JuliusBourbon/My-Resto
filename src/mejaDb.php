<?php
require_once __DIR__ . '/connection.php';

$meja = $conn->query("SELECT * FROM meja WHERE nomor != 11");
$mejaTersedia = $conn->query("SELECT * FROM meja WHERE status = 'Tersedia'");
$meja11 = $conn->query("SELECT * FROM meja WHERE nomor = 11");

$counter = 1;
$counter11 = 1;

$tersedia = $conn->query("SELECT COUNT(*) AS total FROM meja WHERE status = 'Tersedia'")->fetch_assoc()['total'];
$penuh     = $conn->query("SELECT COUNT(*) AS total FROM meja WHERE status = 'Reservasi'")->fetch_assoc()['total'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan semua data yang dibutuhkan ada
    if (isset($_POST['id_meja'], $_POST['nama'], $_POST['jumlah'])) {
        
        // 1. Langsung ambil id_meja dari form. Tidak perlu query lagi.
        $id_meja        = (int) $_POST['id_meja'];
        $nama_pelanggan = $_POST['nama'];
        $jumlah         = (int) $_POST['jumlah'];

        // Pastikan id_meja valid (lebih dari 0)
        if ($id_meja > 0) {
            // Mulai transaksi untuk memastikan konsistensi data
            $conn->begin_transaction();
            try {
                // 2. Insert ke tabel pesanan menggunakan id_meja yang sudah didapat
                $stmtPesanan = $conn->prepare(
                    "INSERT INTO pesanan (id_meja, id_pelayan, waktu_pesan, status, nama, jumlah_pelanggan)
                     VALUES (?, 1, NOW(), 'Reservasi', ?, ?)"
                );
                // Bind parameter 'isi' -> integer, string, integer
                $stmtPesanan->bind_param("isi", $id_meja, $nama_pelanggan, $jumlah);
                $stmtPesanan->execute();

                // 3. Update status meja menjadi 'Reserved' atau 'Reservasi' (sesuaikan dengan sistem Anda)
                // Di query status Anda adalah 'Reservasiz', tapi di sini 'Reserved'. Mari kita samakan.
                $stmtUpdateMeja = $conn->prepare("UPDATE meja SET status = 'Reserved' WHERE id_meja = ?");
                $stmtUpdateMeja->bind_param("i", $id_meja);
                $stmtUpdateMeja->execute();

                // Jika semua berhasil, commit transaksi
                $conn->commit();
                
                header("Location: /My-Resto/meja"); // Pastikan path ini benar
                exit;

            } catch (Exception $e) {
                // Jika ada error, batalkan semua perubahan
                $conn->rollback();
                // Opsional: Log error untuk debugging
                // error_log("Transaksi gagal: " . $e->getMessage());
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
