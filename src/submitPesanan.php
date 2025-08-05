<?php
    require('connection.php');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); // Method Not Allowed
        echo json_encode(["success" => false, "message" => "Hanya metode POST yang diizinkan."]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $nomor_meja = $data['nomor_meja'];
    $items = $data['pesanan'];

    // Validasi input
    if (empty($nomor_meja) || empty($items)) {
        echo json_encode(["success" => false, "message" => "Data tidak lengkap."]);
        exit;
    }

    $queryPesanan = $conn->prepare("SELECT p.id_pesanan FROM pesanan p
                                JOIN meja m ON p.id_meja = m.id_meja
                                WHERE m.nomor = ? AND p.status != 'Selesai'
                                ORDER BY p.waktu_pesan DESC LIMIT 1");
    $queryPesanan->bind_param("i", $nomor_meja);
    $queryPesanan->execute();
    $resultPesanan = $queryPesanan->get_result();

    if ($row = $resultPesanan->fetch_assoc()) {
        $id_pesanan = $row['id_pesanan'];

        // Mulai Transaksi
        $conn->begin_transaction();

        try {
            // 1. Masukkan item-item baru ke detail_transaksi
            $stmtDetail = $conn->prepare("INSERT INTO detail_transaksi (id_pesanan, id_menu, jumlah, status) VALUES (?, ?, ?, 'dipesan')");
            foreach ($items as $item) {
                if (!empty($item['id_menu']) && !empty($item['jumlah']) && $item['jumlah'] > 0) {
                    $stmtDetail->bind_param("iii", $id_pesanan, $item['id_menu'], $item['jumlah']);
                    $stmtDetail->execute();
                }
            }
            $stmtDetail->close();

            // 4. (Saran) Update status pesanan agar tidak 'Reservasi' lagi
            $stmtUpdateStatus = $conn->prepare("UPDATE pesanan SET status = 'Pending' WHERE id_pesanan = ?");
            $stmtUpdateStatus->bind_param("i", $id_pesanan);
            $stmtUpdateStatus->execute();
            $stmtUpdateStatus->close();

            // Jika semua berhasil, commit
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Item berhasil ditambahkan ke pesanan."]);

        } catch (Exception $e) {
            // Jika ada error, batalkan semua
            $conn->rollback();
            echo json_encode(["success" => false, "message" => "Gagal memproses pesanan: " . $e->getMessage()]);
        }

    } else {
        // Jika tidak ada pesanan dengan status 'Reservasi' ditemukan
        echo json_encode(["success" => false, "message" => "Tidak ada reservasi aktif yang ditemukan untuk meja ini."]);
    }

    $queryPesanan->close();
    $conn->close();
?>