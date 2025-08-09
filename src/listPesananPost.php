<?php
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/../config.php';

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id_pesanan'])) {
    $action = $_POST['action'];
    $id_pesanan = (int) $_POST['id_pesanan'];

    if ($action === 'set_preparing' && $id_pesanan > 0) {
        $conn->begin_transaction();

        try {
            // Hitung total harga pesanan (subtotal)
            $subtotal = 0; // Ganti nama variabel agar lebih jelas
            $stmtHarga = $conn->prepare("
                SELECT SUM(dt.jumlah * m.harga) AS total 
                FROM detail_transaksi dt 
                JOIN menu m ON dt.id_menu = m.id_menu 
                WHERE dt.id_pesanan = ?
            ");
            $stmtHarga->bind_param("i", $id_pesanan);
            $stmtHarga->execute();
            $resultHarga = $stmtHarga->get_result();
            if ($rowHarga = $resultHarga->fetch_assoc()) {
                $subtotal = $rowHarga['total'] ?? 0;
            }
            $stmtHarga->close();
            
            // --- PERUBAHAN DI SINI: Tambahkan PPN 12% ---
            $total_harga = $subtotal * 1.12; // 100% (harga asli) + 12% (pajak)

            // Update status pesanan
            $stmtPesanan = $conn->prepare("UPDATE pesanan SET status = 'Preparing' WHERE id_pesanan = ?");
            $stmtPesanan->bind_param("i", $id_pesanan);
            $stmtPesanan->execute();
            $stmtPesanan->close();

            // Insert ke pembayaran dengan harga yang sudah termasuk pajak
            $stmtPembayaran = $conn->prepare("
                INSERT INTO pembayaran (status, total_harga, id_pesanan) 
                VALUES ('Belum Bayar', ?, ?)
            ");
            // Gunakan variabel $total_harga yang sudah dikalikan pajak
            $stmtPembayaran->bind_param("di", $total_harga, $id_pesanan);
            $stmtPembayaran->execute();
            $stmtPembayaran->close();

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
        }

    } elseif ($action === 'set_canceled' && $id_pesanan > 0) {
        // Ambil catatan dari POST, jika tidak ada beri string kosong
        $note = $_POST['cancel_note'] ?? '';

        $conn->begin_transaction();

        try {
            // PERUBAHAN: Tambahkan 'note = ?' ke query UPDATE
            $stmtPesanan = $conn->prepare("UPDATE pesanan SET status = 'Canceled', note = ? WHERE id_pesanan = ?");
            // PERUBAHAN: bind_param sekarang "si" (string untuk note, integer untuk id)
            $stmtPesanan->bind_param("si", $note, $id_pesanan);
            $stmtPesanan->execute();
            $stmtPesanan->close();

            // Update status di detail_transaksi (tetap sama)
            $stmtDetail = $conn->prepare("UPDATE detail_transaksi SET status = 'Dibatalkan' WHERE id_pesanan = ?");
            $stmtDetail->bind_param("i", $id_pesanan);
            $stmtDetail->execute();
            $stmtDetail->close();

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
        }

    } elseif ($action === 'update_status') {
        $newStatus = $_POST['status'] ?? '';
        if (!empty($newStatus) && $id_pesanan > 0) {
            $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id_pesanan = ?");
            $stmt->bind_param("si", $newStatus, $id_pesanan);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$conn->close();

header("Location: list-pesanan");
exit;
