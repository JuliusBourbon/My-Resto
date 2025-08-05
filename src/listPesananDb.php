<?php
    require('connection.php');

    // 1. Ambil data untuk tabel "Pending"
    $pendingOrders = [];
    // Query diperbaiki: Mengambil 'p.nama' dan menghapus JOIN ke 'pelanggan'
    $queryPending = $conn->query("
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
            p.status = 'Pending'
        ORDER BY 
            p.waktu_pesan ASC
    ");
    if ($queryPending) {
        while ($row = $queryPending->fetch_assoc()) {
            $pendingOrders[] = $row;
        }
    }

    // 2. Ambil data untuk tabel "Terkonfirmasi"
    $confirmedOrders = [];
    // Query diperbaiki: Mengambil 'p.nama' dan menghapus JOIN ke 'pelanggan'
    $queryConfirmed = $conn->query("
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
            p.status IN ('Preparing', 'Ready To Serve')
        ORDER BY 
            p.waktu_pesan ASC
    ");
    if ($queryConfirmed) {
        while ($row = $queryConfirmed->fetch_assoc()) {
            $confirmedOrders[] = $row;
        }
    }

    // 3. Ambil data untuk kartu ringkasan (summary cards) - Tidak ada perubahan di sini
    $queryPreparing = $conn->query("SELECT COUNT(id_pesanan) as total FROM pesanan WHERE status = 'Preparing'");
    $jumlahPreparing = $queryPreparing->fetch_assoc()['total'] ?? 0;

    $queryReady = $conn->query("SELECT COUNT(id_pesanan) as total FROM pesanan WHERE status = 'Ready To Serve'");
    $jumlahReady = $queryReady->fetch_assoc()['total'] ?? 0;


    // 4. Ambil semua detail pesanan untuk Modal - Tidak ada perubahan di sini
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