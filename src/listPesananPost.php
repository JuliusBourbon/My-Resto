<?php
    require('connection.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'];
        $id_pesanan = $_POST['id_pesanan'];

        // Validasi nilai input (optional)
        $allowed_status = ['Preparing', 'Ready To Serve'];
        if (in_array($status, $allowed_status)) {
            $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id_pesanan = ?");
            $stmt->bind_param("si", $status, $id_pesanan);
            $stmt->execute();
        }
    }
?>