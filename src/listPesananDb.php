<?php
    require('connection.php');

    $query = $conn->query("
        SELECT 
            p.id_pesanan,
            p.waktu_pesan,
            m.nomor AS nomor_meja,
            p.nama AS nama_pelanggan,
            p.status
        FROM 
            pesanan p
        JOIN 
            meja m ON p.id_meja = m.id_meja
        ORDER BY 
            p.waktu_pesan ASC
    ");

    $semuaDetailPesanan = [];

    // Ambil semua id_pesanan
    $resultPesanan = $conn->query("SELECT id_pesanan FROM pesanan");
    while ($pesanan = $resultPesanan->fetch_assoc()) {
        $id_pesanan = $pesanan['id_pesanan'];
        $detail = $conn->query("SELECT m.nama, dt.jumlah 
                                FROM detail_transaksi dt 
                                JOIN menu m ON dt.id_menu = m.id_menu 
                                WHERE dt.id_pesanan = $id_pesanan");

        $semuaDetailPesanan[$id_pesanan] = [];
        while ($row = $detail->fetch_assoc()) {
            $semuaDetailPesanan[$id_pesanan][] = $row;
        }
    }

    $result = $conn->query("
        SELECT status, COUNT(*) AS jumlah 
        FROM pesanan 
        WHERE status IN ('Ready To Serve', 'Preparing') 
        GROUP BY status
    ");

    $jumlahReady = 0;
    $jumlahPreparing = 0;

    while ($row = $result->fetch_assoc()) {
        if ($row['status'] === 'Ready To Serve') {
            $jumlahReady = $row['jumlah'];
        } elseif ($row['status'] === 'Preparing') {
            $jumlahPreparing = $row['jumlah'];
        }
    }
?>