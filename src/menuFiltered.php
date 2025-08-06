<?php
require_once __DIR__ . '/../config.php'; 
require_once __DIR__ . '/connection.php';

header('Content-Type: application/json');

$menus = [];

try {

    $sql = "SELECT m.*, k.nama_kategori 
            FROM menu m 
            JOIN kategori_menu k ON m.id_kategori = k.id_kategori";


    if (isset($_GET['kategori_id']) && is_numeric($_GET['kategori_id'])) {
        $kategoriId = intval($_GET['kategori_id']);
        $sql .= " WHERE m.id_kategori = $kategoriId";
    }

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $menus[] = $row;
    }

    echo json_encode($menus);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
