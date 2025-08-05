<?php

    require('connection.php');

    $pendingNotifications = [];
    $queryPending = $conn->query("
        SELECT 
            p.id_pesanan, 
            m.nomor as nomor_meja, 
            p.nama as nama_pelanggan, 
            p.status, 
            p.note, 
            p.waktu_pesan
        FROM 
            pesanan p
        JOIN 
            meja m ON p.id_meja = m.id_meja
        WHERE 
            p.status IN ('Pending', 'Preparing', 'Ready To Serve', 'Canceled')
        ORDER BY 
            p.waktu_pesan ASC
    ");
    if ($queryPending) {
        while ($row = $queryPending->fetch_assoc()) {
            $pendingNotifications[] = $row;
        }
    }

    $finishedOrders = [];
    $queryFinished = $conn->query("
        SELECT 
            p.id_pesanan, 
            m.nomor as nomor_meja, 
            p.nama as nama_pelanggan, 
            p.status, 
            p.waktu_pesan
        FROM 
            pesanan p
        JOIN 
            meja m ON p.id_meja = m.id_meja
        WHERE 
            p.status IN ('Selesai', 'Served')
        ORDER BY 
            p.waktu_pesan DESC
        LIMIT 20 
    ");
    if ($queryFinished) {
        while ($row = $queryFinished->fetch_assoc()) {
            $finishedOrders[] = $row;
        }
    }

    $semuaDetailPesanan = [];
    $queryDetail = $conn->query("
        SELECT dt.id_pesanan, m.nama as nama_menu, dt.jumlah 
        FROM detail_transaksi dt 
        JOIN menu m ON dt.id_menu = m.id_menu
    ");
    if ($queryDetail) {
        while ($row = $queryDetail->fetch_assoc()) {
            $semuaDetailPesanan[$row['id_pesanan']][] = [
                'nama_menu' => $row['nama_menu'],
                'jumlah' => $row['jumlah']
            ];
        }
    }

    $conn->close();
?>