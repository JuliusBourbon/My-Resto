<?php
    require('connection.php');

    // Pastikan ada data yang dikirim
    if (isset($_POST['action']) && isset($_POST['id_pesanan'])) {
        
        $action = $_POST['action'];
        $id_pesanan = (int)$_POST['id_pesanan'];
        $newStatus = '';

        // Tentukan status baru berdasarkan aksi
        switch ($action) {
            case 'set_preparing':
                $newStatus = 'Preparing';
                break;
            case 'set_canceled':
                $newStatus = 'Canceled';
                // Di sini Anda bisa menambahkan logika untuk 'note' jika perlu
                break;
            case 'update_status':
                // Ambil status baru dari dropdown
                if (isset($_POST['status'])) {
                    $newStatus = $_POST['status'];
                }
                break;
        }

        // Jika status baru valid, update database
        if ($newStatus !== '' && $id_pesanan > 0) {
            $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id_pesanan = ?");
            $stmt->bind_param("si", $newStatus, $id_pesanan);
            $stmt->execute();
            $stmt->close();
        }
    }

    $conn->close();

    // Redirect kembali ke halaman list pesanan setelah selesai
    // Pastikan path ini benar sesuai struktur folder Anda
    header("Location: ../view/listPesanan.php");
    exit;
?>