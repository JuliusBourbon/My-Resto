<?php
require_once __DIR__ . '/connection.php';
header('Content-Type: application/json');

// Ambil id_pesanan dari parameter URL
$id_pesanan = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_pesanan <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID Pesanan tidak valid.']);
    exit;
}

// Query untuk mengambil detail item berdasarkan id_pesanan
$sql = "SELECT dt.jumlah, m.nama
        FROM detail_transaksi dt
        JOIN menu m ON dt.id_menu = m.id_menu
        WHERE dt.id_pesanan = ?
        ORDER BY m.nama ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pesanan);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

// Kembalikan data dalam format JSON
echo json_encode($items);