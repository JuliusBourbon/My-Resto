<?php
require_once __DIR__ . '/connection.php';

// === Fungsi: Ambil semua pesanan yang belum dibayar ===
function getUnpaidOrders() {
    global $conn;

    $sql = "
        SELECT 
            p.id_pesanan,
            p.nama AS nama_pelanggan,
            py.total_harga,
            py.status,
            -- --- BLOK PERUBAHAN DIMULAI DI SINI ---
            CASE
                WHEN m.nomor = 11 
                THEN CONCAT('11-', CASE WHEN m.id_meja % 10 = 0 THEN 10 ELSE m.id_meja % 10 END)
                ELSE m.nomor
            END AS nomor_meja
            -- --- BLOK PERUBAHAN SELESAI ---
        FROM pembayaran py
        JOIN pesanan p ON py.id_pesanan = p.id_pesanan
        JOIN meja m ON p.id_meja = m.id_meja
        WHERE py.status = 'Belum Bayar'
        ORDER BY p.waktu_pesan ASC
    ";

    $result = $conn->query($sql);
    $orders = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }

    return $orders;
}

// === Fungsi: Ambil detail satu pesanan ===
function getOrderDetail($orderId) {
    global $conn;

    $info = [];
    $items = [];

    $stmtInfo = $conn->prepare("
        SELECT 
            p.id_pesanan, 
            p.nama AS nama_pelanggan, -- Ambil nama pelanggan yang benar
            CASE
                WHEN m.nomor = 11 
                THEN CONCAT('11-', CASE WHEN m.id_meja % 10 = 0 THEN 10 ELSE m.id_meja % 10 END)
                ELSE m.nomor
            END AS nomor_meja_formatted
        FROM pesanan p 
        JOIN meja m ON p.id_meja = m.id_meja 
        WHERE p.id_pesanan = ?
    ");
    $stmtInfo->bind_param("i", $orderId);
    $stmtInfo->execute();
    $infoResult = $stmtInfo->get_result();
    $info = $infoResult->fetch_assoc();
    $stmtInfo->close();

    $stmtItems = $conn->prepare("
        SELECT m.nama AS nama_menu, dt.jumlah AS qty, m.harga 
        FROM detail_transaksi dt 
        JOIN menu m ON dt.id_menu = m.id_menu 
        WHERE dt.id_pesanan = ?
    ");
    $stmtItems->bind_param("i", $orderId);
    $stmtItems->execute();
    $itemsResult = $stmtItems->get_result();
    while ($row = $itemsResult->fetch_assoc()) {
        $items[] = $row;
    }
    $stmtItems->close();

    return ['info' => $info, 'items' => $items];
}

// === Endpoint: Konfirmasi Pembayaran (POST) ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'confirm_payment') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    
    $orderId = $input['id_pesanan'] ?? null;
    $metode = $input['metode'] ?? null;

    if (!$orderId || !$metode) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
        exit;
    }

    try {
        $conn->begin_transaction();

        // Update status pembayaran
        $stmtPembayaran = $conn->prepare("UPDATE pembayaran SET status = 'Lunas', metode = ?, tanggal_pembayaran = NOW() WHERE id_pesanan = ? AND status = 'Belum Bayar'");
        $stmtPembayaran->bind_param("si", $metode, $orderId);
        $stmtPembayaran->execute();
        if ($stmtPembayaran->affected_rows === 0) {
            throw new Exception("Pembayaran tidak ditemukan atau sudah lunas.");
        }

        $stmtUpdatePesanan = $conn->prepare("UPDATE pesanan SET status = 'Lunas' WHERE id_pesanan = ?");
        $stmtUpdatePesanan->bind_param("i", $orderId);
        $stmtUpdatePesanan->execute();
        $stmtUpdatePesanan->close();

        // Ambil id_meja
        $stmtGetMeja = $conn->prepare("SELECT id_meja FROM pesanan WHERE id_pesanan = ?");
        $stmtGetMeja->bind_param("i", $orderId);
        $stmtGetMeja->execute();
        $resultMeja = $stmtGetMeja->get_result();

        if ($meja = $resultMeja->fetch_assoc()) {
            $id_meja = $meja['id_meja'];

            // Set status meja jadi Tersedia
            $stmtUpdateMeja = $conn->prepare("UPDATE meja SET status = 'Tersedia' WHERE id_meja = ?");
            $stmtUpdateMeja->bind_param("i", $id_meja);
            $stmtUpdateMeja->execute();
            $stmtUpdateMeja->close();
        } else {
            throw new Exception("Data pesanan terkait tidak ditemukan.");
        }

        $conn->commit();
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
    }

    $stmtPembayaran->close();
    $stmtGetMeja->close();
    $conn->close();
    exit;
}

// === Endpoint: Ambil Detail Pesanan (GET) ===
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    header('Content-Type: application/json');

    if ($_GET['action'] === 'get_order_detail' && isset($_GET['id'])) {
        $orderId = intval($_GET['id']);
        $detail = getOrderDetail($orderId);
        echo json_encode($detail);
        exit;
    }
    
}
?>
