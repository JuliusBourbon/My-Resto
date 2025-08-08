<?php
require_once __DIR__ . '/../config.php'; 
require_once __DIR__ . '/connection.php';

header('Content-Type: application/json');

$kategori_id = $_GET['kategori_id'] ?? null;

$sql = "SELECT m.id_menu, m.nama, m.harga, m.status_ketersediaan, k.nama_kategori 
        FROM menu m 
        JOIN kategori_menu k ON m.id_kategori = k.id_kategori
        WHERE m.status_ketersediaan != 'Deleted'"; 
$params = [];
$types = ""; 

if ($kategori_id && is_numeric($kategori_id)) {
    $sql .= " AND m.id_kategori = ?"; 
    $params[] = (int) $kategori_id;
    $types .= "i";
}

$sql .= " ORDER BY m.nama ASC";

// Siapkan statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal menyiapkan statement: ' . $conn->error]);
    exit();
}

if (!empty($types) && !empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data);

$stmt->close();
$conn->close();
