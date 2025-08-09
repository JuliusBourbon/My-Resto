<?php
    require_once __DIR__ . '/connection.php';

    $query_histori = "
    SELECT 
        p.nama AS nama_pelanggan,
        py.metode AS metode_pembayaran,
        py.total_harga,
        py.tanggal_pembayaran,
        py.id_pesanan
    FROM 
        pembayaran py
    JOIN 
        pesanan p ON py.id_pesanan = p.id_pesanan
    WHERE
        py.status = 'Lunas'
    ORDER BY 
        py.tanggal_pembayaran DESC
";

$histori_pembayaran = $conn->query($query_histori);


?>