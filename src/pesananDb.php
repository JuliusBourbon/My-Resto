<?php
    require('connection.php');

    $kategori = $conn->query("SELECT * FROM kategori_menu");
    $menu = $conn->query("SELECT m.*, k.nama_kategori 
                      FROM menu m 
                      JOIN kategori_menu k ON m.id_kategori = k.id_kategori");

    $mejaReserved = $conn->query("SELECT * FROM meja WHERE status = 'Reserved'");
    $counter11 = 1;

    $pesananNama = null;

    if (isset($_GET['meja']) && $_GET['meja'] !== '') {
        $nomor_meja = (int) $_GET['meja'];
        
        // Dapatkan id_meja berdasarkan nomor meja
        $result = $conn->query("SELECT id_meja FROM meja WHERE nomor = $nomor_meja");
        if ($result && $row = $result->fetch_assoc()) {
            $id_meja = $row['id_meja'];

            // Cari nama pelanggan untuk pesanan dengan status Reservasi pada meja ini
            $queryPesanan = $conn->query("SELECT nama FROM pesanan WHERE id_meja = $id_meja AND status = 'Reservasi' ORDER BY waktu_pesan DESC LIMIT 1");

            if ($queryPesanan && $data = $queryPesanan->fetch_assoc()) {
                $pesananNama = $data['nama'];
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        $nomor_meja = $data['nomor_meja'];
        $items = $data['pesanan'];

        // Dapatkan id_pesanan aktif berdasarkan nomor meja
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