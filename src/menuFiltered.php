<?php
    require('connection.php');

    header('Content-Type: application/json'); // PENTING agar browser tahu ini JSON

    if (isset($_GET['kategori_id'])) {
        $kategoriId = intval($_GET['kategori_id']);

        $result = $conn->query("SELECT m.*, k.nama_kategori 
                                FROM menu m 
                                JOIN kategori_menu k ON m.id_kategori = k.id_kategori 
                                WHERE m.id_kategori = $kategoriId");

        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $menus[] = $row;
        }

        echo json_encode($menus);
    } else {
        // Jika tidak ada kategori_id, balas semua menu
        $result = $conn->query("SELECT m.*, k.nama_kategori 
                                FROM menu m 
                                JOIN kategori_menu k ON m.id_kategori = k.id_kategori");

        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $menus[] = $row;
        }

        echo json_encode($menus);
    }
?>