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
    // $menus = [];

    // if (isset($_GET['kategori_id'])) {
    //     $kategoriId = intval($_GET['kategori_id']);
    //     $result = $conn->query("SELECT m.*, k.nama_kategori 
    //                             FROM menu m 
    //                             JOIN kategori_menu k ON m.id_kategori = k.id_kategori 
    //                             WHERE m.id_kategori = $kategoriId");
    // } else {
    //     // tampilkan semua
    //     $result = $conn->query("SELECT m.*, k.nama_kategori 
    //                             FROM menu m 
    //                             JOIN kategori_menu k ON m.id_kategori = k.id_kategori");
    // }

    // while ($row = $result->fetch_assoc()) {
    //     $menus[] = $row;
    // }

    // echo json_encode($menus);
?>