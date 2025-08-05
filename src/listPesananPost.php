<?php
    require('connection.php');

    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    if (isset($_POST['action']) && isset($_POST['id_pesanan'])) {
        
        $action = $_POST['action'];
        $id_pesanan = (int)$_POST['id_pesanan'];

        if ($action === 'set_preparing' && $id_pesanan > 0) {
            
            $conn->begin_transaction();
            
            try {
                $total_harga = 0;
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
                    $total_harga = $rowHarga['total'] ?? 0;
                }
                $stmtHarga->close();
                
                $stmtPesanan = $conn->prepare("UPDATE pesanan SET status = 'Preparing' WHERE id_pesanan = ?");
                $stmtPesanan->bind_param("i", $id_pesanan);
                $stmtPesanan->execute();
                $stmtPesanan->close();

                $stmtPembayaran = $conn->prepare("INSERT INTO pembayaran (status, total_harga, id_pesanan) VALUES ('Belum Bayar', ?, ?)");
                $stmtPembayaran->bind_param("di", $total_harga, $id_pesanan);
                $stmtPembayaran->execute();
                $stmtPembayaran->close();

                $conn->commit();

            } catch (Exception $e) {
                $conn->rollback();
            }

        }
        elseif ($action === 'set_canceled' && $id_pesanan > 0) {
            
            $conn->begin_transaction();
            try {
                $stmtPesanan = $conn->prepare("UPDATE pesanan SET status = 'Canceled' WHERE id_pesanan = ?");
                $stmtPesanan->bind_param("i", $id_pesanan);
                $stmtPesanan->execute();
                $stmtPesanan->close();

                $stmtDetail = $conn->prepare("UPDATE detail_transaksi SET status = 'Dibatalkan' WHERE id_pesanan = ?");
                $stmtDetail->bind_param("i", $id_pesanan);
                $stmtDetail->execute();
                $stmtDetail->close();
                
                $conn->commit();
            } catch (Exception $e) {
                $conn->rollback();
            }

        } 
        elseif ($action === 'update_status') {
            $newStatus = $_POST['status'] ?? '';
            if ($newStatus !== '' && $id_pesanan > 0) {
                $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id_pesanan = ?");
                $stmt->bind_param("si", $newStatus, $id_pesanan);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    $conn->close();

    header("Location: ../view/listPesanan.php");
    exit;
?>