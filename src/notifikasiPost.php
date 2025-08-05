<?php
    require('connection.php');

    if (isset($_POST['action']) && isset($_POST['id_pesanan'])) {
        
        $action = $_POST['action'];
        $id_pesanan = (int)$_POST['id_pesanan'];

        if ($action === 'set_served' && $id_pesanan > 0) {
            $stmt = $conn->prepare("UPDATE pesanan SET status = 'Served' WHERE id_pesanan = ?");
            $stmt->bind_param("i", $id_pesanan);
            $stmt->execute();
            $stmt->close();
        }

        if ($action === 'set_reorder' && $id_pesanan > 0) {
            $stmt = $conn->prepare("UPDATE pesanan SET status = 'Reservasi' WHERE id_pesanan = ?");
            $stmt->bind_param("i", $id_pesanan);
            $stmt->execute();
            $stmt->close();
        }

        if ($action === 'set_finish_order' && $id_pesanan > 0) {
            $conn->begin_transaction();
            try {
                $stmtGetMeja = $conn->prepare("SELECT id_meja FROM pesanan WHERE id_pesanan = ?");
                $stmtGetMeja->bind_param("i", $id_pesanan);
                $stmtGetMeja->execute();
                $resultMeja = $stmtGetMeja->get_result();

                if ($meja = $resultMeja->fetch_assoc()) {
                    $id_meja = $meja['id_meja'];

                    $stmtPesanan = $conn->prepare("UPDATE pesanan SET status = 'Selesai' WHERE id_pesanan = ?");
                    $stmtPesanan->bind_param("i", $id_pesanan);
                    $stmtPesanan->execute();

                    $stmtMeja = $conn->prepare("UPDATE meja SET status = 'Tersedia' WHERE id_meja = ?");
                    $stmtMeja->bind_param("i", $id_meja);
                    $stmtMeja->execute();
                    
                    $conn->commit();
                } else {
                    throw new Exception("Pesanan tidak ditemukan.");
                }
            } catch (Exception $e) {
                $conn->rollback();
            }
        }
    }

    $conn->close();
    header("Location: ../view/notifikasi.php");
    exit;
?>