<?php
require('connection.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $nomor_meja = $data['nomor_meja'];
    $items = $data['pesanan'];

    // Cek id_pesanan aktif
    $query = $conn->prepare("SELECT p.id_pesanan FROM pesanan p
                            JOIN meja m ON p.id_meja = m.id_meja
                            WHERE m.nomor = ? AND p.status = 'Reservasi'
                            ORDER BY p.waktu_pesan DESC LIMIT 1");
    $query->bind_param("i", $nomor_meja);
    $query->execute();
    $result = $query->get_result();

    if ($row = $result->fetch_assoc()) {
        $id_pesanan = $row['id_pesanan'];

        $stmt = $conn->prepare("INSERT INTO detail_transaksi (id_pesanan, id_menu, jumlah, status) VALUES (?, ?, ?, 'dipesan')");

        foreach ($items as $item) {
            $id_menu = $item['id_menu'];
            $jumlah = $item['jumlah'];
            if ($jumlah > 0) {
                $stmt->bind_param("iii", $id_pesanan, $id_menu, $jumlah);
                $stmt->execute();
            }
        }

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Pesanan tidak ditemukan"]);
    }
}
?>
