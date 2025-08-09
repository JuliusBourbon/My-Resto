<?php
    require_once __DIR__ . '/connection.php';
    header('Content-Type: application/json');

    // Ambil parameter tanggal dari URL
    $start_date = $_GET['start_date'] ?? null;
    $end_date = $_GET['end_date'] ?? null;

    // Query dasar
    $sql = "SELECT p.nama AS nama_pelanggan, py.metode AS metode_pembayaran, py.total_harga, py.tanggal_pembayaran, py.id_pesanan
            FROM pembayaran py
            JOIN pesanan p ON py.id_pesanan = p.id_pesanan
            WHERE py.status = 'Lunas'";

    $params = [];
    $types = "";

    // Jika kedua tanggal ada, tambahkan kondisi BETWEEN
    if ($start_date && $end_date) {
        $sql .= " AND DATE(py.tanggal_pembayaran) BETWEEN ? AND ?";
        $params[] = $start_date;
        $params[] = $end_date;
        $types .= "ss"; // 's' untuk string
    }

    $sql .= " ORDER BY py.tanggal_pembayaran DESC";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Gagal menyiapkan statement: ' . $conn->error]);
        exit();
    }

    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($data);

    $stmt->close();
    $conn->close();