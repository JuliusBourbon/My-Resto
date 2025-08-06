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
        $nama_pelanggan = $_POST['nama']; // Kita akan escape nanti di dalam query
        $jumlah         = (int) $_POST['jumlah'];

        // Gunakan Prepared Statements untuk keamanan
        
        // 1. Dapatkan id_meja dari nomor meja
        $stmtMeja = $conn->prepare("SELECT id_meja FROM meja WHERE nomor = ? LIMIT 1");
        $stmtMeja->bind_param("i", $nomor_meja);
        $stmtMeja->execute();
        $resultMeja = $stmtMeja->get_result();
        
        if ($resultMeja && $rowMeja = $resultMeja->fetch_assoc()) {
            $id_meja = $rowMeja['id_meja'];

            // Mulai transaksi untuk memastikan kedua query berhasil
            $conn->begin_transaction();
            try {
                // 2. Insert ke tabel pesanan
                $stmtPesanan = $conn->prepare(
                    "INSERT INTO pesanan (id_meja, id_pelayan, waktu_pesan, status, nama, jumlah_pelanggan)
                     VALUES (?, 1, NOW(), 'Reservasi', ?, ?)"
                );
                $stmtPesanan->bind_param("isi", $id_meja, $nama_pelanggan, $jumlah);
                $stmtPesanan->execute();

                // 3. Update status meja
                $stmtUpdateMeja = $conn->prepare("UPDATE meja SET status = 'Reserved' WHERE id_meja = ?");
                $stmtUpdateMeja->bind_param("i", $id_meja);
                $stmtUpdateMeja->execute();

                // Jika semua berhasil, commit
                $conn->commit();
                
                header("Location: /My-Resto/meja"); // Pastikan path ini benar
                exit;

            } catch (Exception $e) {
                // Jika ada error, batalkan semua
                $conn->rollback();
                // Opsional: Tampilkan pesan error saat development
                // die("Transaksi gagal: " . $e->getMessage());
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
