<?php
    require('connection.php');

    $meja = $conn->query("SELECT * FROM meja WHERE nomor != 11");
    $mejaTersedia = $conn->query("SELECT * FROM meja WHERE status = 'Tersedia'");
    $meja11 = $conn->query("SELECT * FROM meja WHERE nomor = 11");
    $counter = 1;
    $counter11 = 1;
    $tersedia = $conn->query("SELECT COUNT(*) AS total FROM meja WHERE status = 'Tersedia'")->fetch_assoc()['total'];
    $penuh = $conn->query("SELECT COUNT(*) AS total FROM meja WHERE status = 'Reserved'")->fetch_assoc()['total'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['meja']) && isset($_POST['nama'])) {
            $nomor_meja = $_POST['meja'];
            $nama_pelanggan = $_POST['nama'];
            $jumlah = $_POST['jumlah'] ?? null;

            // Cek id_meja
            $query = $conn->query("SELECT id_meja FROM meja WHERE nomor = $nomor_meja");
            $row = $query->fetch_assoc();
            $id_meja = $row['id_meja'];

            // Insert ke pesanan
            $conn->query("INSERT INTO pesanan (id_meja, id_pelayan, waktu_pesan, status, nama)
              VALUES ($id_meja, 1, NOW(), 'Reservasi', '$nama_pelanggan')");


            // Update status meja
            $conn->query("UPDATE meja SET status = 'Reserved' WHERE id_meja = $id_meja");

            header("Location: ../view/meja.php");
            exit;
        }
    }

    if (isset($_GET['nomor_meja'])) {
        $nomor_meja = (int) $_GET['nomor_meja'];

        $result = $conn->query("SELECT id_meja FROM meja WHERE nomor = $nomor_meja");
        if ($row = $result->fetch_assoc()) {
            $id_meja = $row['id_meja'];

            $pesanan = $conn->query("SELECT nama FROM pesanan WHERE id_meja = $id_meja AND status = 'Reservasi' ORDER BY waktu_pesan DESC LIMIT 1");

            if ($pesanan && $data = $pesanan->fetch_assoc()) {
                echo json_encode(['nama' => $data['nama']]);
            } else {
                echo json_encode(['nama' => '']);
            }
        }
    }
?>