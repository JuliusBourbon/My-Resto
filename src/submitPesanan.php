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
$nomor_meja = intval($data['nomor_meja'] ?? 0);
$items = $data['pesanan'] ?? [];

// Validasi dasar
if ($nomor_meja <= 0 || empty($items) || !is_array($items)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Data tidak lengkap atau tidak valid."]);
    exit;
}

// Ambil ID pesanan aktif untuk meja yang bersangkutan
$queryPesanan = $conn->prepare("
    SELECT p.id_pesanan, p.status 
    FROM pesanan p
    JOIN meja m ON p.id_meja = m.id_meja
    WHERE m.nomor = ? AND p.status != 'Selesai'
    ORDER BY p.waktu_pesan DESC LIMIT 1
");
$queryPesanan->bind_param("i", $nomor_meja);
$queryPesanan->execute();
$result = $queryPesanan->get_result();
$queryPesanan->close();

if (!$row = $result->fetch_assoc()) {
    echo json_encode(["success" => false, "message" => "Tidak ada reservasi aktif untuk meja ini."]);
    exit;
}

$id_pesanan = $row['id_pesanan'];
$status_pesanan = $row['status'];

// Filter item valid (jumlah > 0 dan id_menu valid)
$valid_items = array_filter($items, function($item) {
    return isset($item['id_menu'], $item['jumlah']) && intval($item['id_menu']) > 0 && intval($item['jumlah']) > 0;
});

if (empty($valid_items)) {
    echo json_encode(["success" => false, "message" => "Tidak ada item valid untuk diproses."]);
    exit;
}

// Mulai transaksi
$conn->begin_transaction();

try {
    // Masukkan setiap item ke detail_transaksi
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

    // Jika status sebelumnya adalah 'Reservasi', ubah ke 'Pending'
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
    echo json_encode(["success" => false, "message" => "Gagal memproses pesanan: " . $e->getMessage()]);
}

$conn->close();
