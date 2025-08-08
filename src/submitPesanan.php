<?php
require_once __DIR__ . '/connection.php';
header('Content-Type: application/json');

// Validasi metode
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Hanya metode POST yang diizinkan."]);
    exit;
}

// Ambil dan decode input JSON
$data = json_decode(file_get_contents("php://input"), true);
$id_meja = intval($data['id_meja'] ?? 0);
$items = $data['pesanan'] ?? [];

// Validasi dasar
if ($id_meja <= 0 || empty($items) || !is_array($items)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Data tidak lengkap atau tidak valid."]);
    exit;
}

$queryPesanan = $conn->prepare("
    SELECT p.id_pesanan, p.status 
    FROM pesanan p
    WHERE p.id_meja = ? AND p.status IN ('Reservasi', 'Pending')
    ORDER BY p.waktu_pesan DESC LIMIT 1
");
$queryPesanan->bind_param("i", $id_meja);
$queryPesanan->execute();
$result = $queryPesanan->get_result();
$queryPesanan->close();

if ($row = $result->fetch_assoc()) {
    $id_pesanan = $row['id_pesanan'];
    $status_pesanan = $row['status'];
} else {
    $stmtLastOrder = $conn->prepare("SELECT nama, jumlah_pelanggan FROM pesanan WHERE id_meja = ? ORDER BY waktu_pesan DESC LIMIT 1");
    $stmtLastOrder->bind_param("i", $id_meja);
    $stmtLastOrder->execute();
    $lastOrderResult = $stmtLastOrder->get_result();
    $lastOrderData = $lastOrderResult->fetch_assoc();
    $stmtLastOrder->close();

    $nama_pelanggan = $lastOrderData['nama'] ?? 'Pelanggan'; 
    $jumlah_pelanggan = $lastOrderData['jumlah_pelanggan'] ?? 1;

    $stmtNewOrder = $conn->prepare("INSERT INTO pesanan (id_meja, nama, jumlah_pelanggan, status) VALUES (?, ?, ?, 'Pending')");
    $stmtNewOrder->bind_param("isi", $id_meja, $nama_pelanggan, $jumlah_pelanggan);
    $stmtNewOrder->execute();
    
    $id_pesanan = $conn->insert_id; 
    $status_pesanan = 'Pending'; 
    
    $stmtNewOrder->close();
}

$valid_items = array_filter($items, function($item) {
    return isset($item['id_menu'], $item['jumlah']) && intval($item['id_menu']) > 0 && intval($item['jumlah']) > 0;
});
if (empty($valid_items)) {
    echo json_encode(["success" => false, "message" => "Tidak ada item valid untuk diproses."]);
    exit;
}

$conn->begin_transaction();
try {
    $stmtDetail = $conn->prepare("
        INSERT INTO detail_transaksi (id_pesanan, id_menu, jumlah, status)
        VALUES (?, ?, ?, 'dipesan')
    ");

    foreach ($valid_items as $item) {
        $id_menu = intval($item['id_menu']);
        $jumlah = intval($item['jumlah']);
        $stmtDetail->bind_param("iii", $id_pesanan, $id_menu, $jumlah);
        $stmtDetail->execute();
    }
    $stmtDetail->close();

    if ($status_pesanan === 'Reservasi') {
        $stmtStatus = $conn->prepare("UPDATE pesanan SET status = 'Pending' WHERE id_pesanan = ?");
        $stmtStatus->bind_param("i", $id_pesanan);
        $stmtStatus->execute();
        $stmtStatus->close();
    }

    $conn->commit();
    echo json_encode(["success" => true, "message" => "Pesanan berhasil ditambahkan."]);

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Gagal memproses pesanan: " . $e->getMessage()]);
}

$conn->close();