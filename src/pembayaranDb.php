<?php
    function getUnpaidOrders() {
        require 'connection.php';

        $query = "
            SELECT 
                p.id_pesanan,
                m.nomor AS nama_pelanggan, -- Menggunakan nomor meja sebagai nama
                py.total_harga,
                py.status
            FROM 
                pembayaran py
            JOIN 
                pesanan p ON py.id_pesanan = p.id_pesanan
            JOIN 
                meja m ON p.id_meja = m.id_meja
            WHERE 
                py.status = 'Belum Bayar'
            ORDER BY 
                p.waktu_pesan ASC
        ";

        $result = $conn->query($query);
        $orders = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        $conn->close();
        return $orders;
    }

    function getOrderDetail($orderId) {
        require 'connection.php';

        $stmtInfo = $conn->prepare("
            SELECT p.id_pesanan, m.nomor AS nama_pelanggan 
            FROM pesanan p 
            JOIN meja m ON p.id_meja = m.id_meja 
            WHERE p.id_pesanan = ?
        ");
        $stmtInfo->bind_param("i", $orderId);
        $stmtInfo->execute();
        $infoResult = $stmtInfo->get_result()->fetch_assoc();

        $stmtItems = $conn->prepare("
            SELECT m.nama AS nama_menu, dt.jumlah AS qty, m.harga 
            FROM detail_transaksi dt 
            JOIN menu m ON dt.id_menu = m.id_menu 
            WHERE dt.id_pesanan = ?
        ");
        $stmtItems->bind_param("i", $orderId);
        $stmtItems->execute();
        $itemsResult = $stmtItems->get_result();
        
        $items = [];
        while ($row = $itemsResult->fetch_assoc()) {
            $items[] = $row;
        }

        $conn->close();

        return [
            'info' => $infoResult,
            'items' => $items
        ];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (isset($_GET['action']) && $_GET['action'] === 'confirm_payment') {
            $orderId = $input['id_pesanan'] ?? null;
            $metode = $input['metode_pembayaran'] ?? 'Tidak diketahui';

            if ($orderId) {
                require 'connection.php';
                
                $conn->begin_transaction();

                try {
                    $stmtPembayaran = $conn->prepare("
                        UPDATE pembayaran SET status = 'Lunas', metode = ? WHERE id_pesanan = ? AND status = 'Belum Bayar'
                    ");
                    $stmtPembayaran->bind_param("si", $metode, $orderId);
                    $stmtPembayaran->execute();

                    if ($stmtPembayaran->affected_rows === 0) {
                        throw new Exception("Pembayaran tidak ditemukan atau sudah lunas.");
                    }

                    $stmtGetMeja = $conn->prepare("SELECT id_meja FROM pesanan WHERE id_pesanan = ?");
                    $stmtGetMeja->bind_param("i", $orderId);
                    $stmtGetMeja->execute();
                    $resultMeja = $stmtGetMeja->get_result();

                    if ($meja = $resultMeja->fetch_assoc()) {
                        $id_meja = $meja['id_meja'];

                        $stmtUpdateMeja = $conn->prepare("UPDATE meja SET status = 'Tersedia' WHERE id_meja = ?");
                        $stmtUpdateMeja->bind_param("i", $id_meja);
                        $stmtUpdateMeja->execute();
                    } else {
                        throw new Exception("Data pesanan terkait tidak ditemukan untuk mengambil ID Meja.");
                    }
                    
                    $conn->commit();
                    echo json_encode(['success' => true]);

                } catch (Exception $e) {
                    $conn->rollback();
                    echo json_encode(['success' => false, 'message' => 'Gagal memproses: ' . $e->getMessage()]);
                }

                if (isset($stmtPembayaran)) $stmtPembayaran->close();
                if (isset($stmtGetMeja)) $stmtGetMeja->close();
                if (isset($stmtUpdateMeja)) $stmtUpdateMeja->close();
                $conn->close();

            } else {
                echo json_encode(['success' => false, 'message' => 'ID Pesanan tidak valid.']);
            }
            exit;
        }
    }


    if (isset($_GET['action'])) {
        header('Content-Type: application/json');

        if ($_GET['action'] === 'get_order_detail' && isset($_GET['id'])) {
            $orderId = intval($_GET['id']);
            $detail = getOrderDetail($orderId);
            echo json_encode($detail);
            exit; 
        }
    }

    
?>