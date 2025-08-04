<?php
    require('connection.php');

    $query = $conn->query("
        SELECT 
            p.id_pesanan,
            m.nomor AS nomor_meja,
            p.nama AS nama_pelanggan,
            p.status
        FROM 
            pesanan p
        JOIN 
            meja m ON p.id_meja = m.id_meja
        ORDER BY 
            p.waktu_pesan DESC
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
?>