<?php
require_once __DIR__ . '/connection.php';
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../config.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id_pesanan'])) {
    $action = $_POST['action'];
    $id_pesanan = (int) $_POST['id_pesanan'];

    try {
        if ($action === 'set_served' && $id_pesanan > 0) {
            $stmt = $conn->prepare("UPDATE pesanan SET status = 'Served' WHERE id_pesanan = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id_pesanan);
                $stmt->execute();
                $stmt->close();
            }
        }

        elseif ($action === 'set_reorder' && $id_pesanan > 0) {
            $stmt = $conn->prepare("UPDATE pesanan SET status = 'Reservasi' WHERE id_pesanan = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id_pesanan);
                $stmt->execute();
                $stmt->close();
            }
        }

        elseif ($action === 'set_finish_order' && $id_pesanan > 0) {
            $conn->begin_transaction();

            // 1. Ambil id_meja dari pesanan
            $stmtGetMeja = $conn->prepare("SELECT id_meja FROM pesanan WHERE id_pesanan = ?");
            if (!$stmtGetMeja) throw new Exception("Gagal menyiapkan statement get_meja");
            $stmtGetMeja->bind_param("i", $id_pesanan);
            $stmtGetMeja->execute();
            $resultMeja = $stmtGetMeja->get_result();

            if ($meja = $resultMeja->fetch_assoc()) {
                $id_meja = $meja['id_meja'];

                // 2. Update status pesanan
                $stmtPesanan = $conn->prepare("UPDATE pesanan SET status = 'Selesai' WHERE id_pesanan = ?");
                if (!$stmtPesanan) throw new Exception("Gagal menyiapkan statement update pesanan");
                $stmtPesanan->bind_param("i", $id_pesanan);
                $stmtPesanan->execute();
                $stmtPesanan->close();

                // 3. Update status meja
                $stmtMeja = $conn->prepare("UPDATE meja SET status = 'Tersedia' WHERE id_meja = ?");
                if (!$stmtMeja) throw new Exception("Gagal menyiapkan statement update meja");
                $stmtMeja->bind_param("i", $id_meja);
                $stmtMeja->execute();
                $stmtMeja->close();

                $conn->commit();
            } else {
                throw new Exception("Pesanan tidak ditemukan.");
            }
        }
    } catch (Exception $e) {
        $conn->rollback();
    
        error_log("Error di notifikasiPost.php: " . $e->getMessage());
    }
}

$conn->close();


header("Location: /My-Resto/notifikasi");
exit;
