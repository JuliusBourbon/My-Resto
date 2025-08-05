<?php
    require('connection.php');

    $kategori = $conn->query("SELECT * FROM kategori_menu");
    $menu = $conn->query("SELECT * FROM menu");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_menu = intval($_POST['id_menu']);
        $status = $_POST['status_ketersediaan'];

        $stmt = $conn->prepare("UPDATE menu SET status_ketersediaan = ? WHERE id_menu = ?");
        $stmt->bind_param("si", $status, $id_menu);
        $stmt->execute();
    }
?>