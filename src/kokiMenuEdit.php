<?php
require_once __DIR__ . '/connection.php';

// Pastikan request datang dari method POST dan ada parameter 'action'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $action = $_POST['action'];

    if ($action === 'update_menu') {

        if (isset($_POST['id_menu'], $_POST['nama'], $_POST['harga']) && !empty($_POST['nama']) && !empty($_POST['harga'])) {
            
            $id_menu = (int) $_POST['id_menu'];
            $nama_baru = $_POST['nama'];
            $harga_baru = (float) $_POST['harga'];

            $sql = "UPDATE menu SET nama = ?, harga = ? WHERE id_menu = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // bind_param: "s" untuk string (nama), "d" untuk double (harga), "i" untuk integer (id)
                $stmt->bind_param("sdi", $nama_baru, $harga_baru, $id_menu);

                if ($stmt->execute()) {
                    // Redirect kembali ke halaman menu koki
                    header("Location: ../koki-menu");
                    exit();
                } else {
                    echo "Error: Gagal mengupdate menu. " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error: Gagal menyiapkan statement. " . $conn->error;
            }
        } else {
            die("Data untuk update menu tidak lengkap.");
        }
    }
    
    // ... (logika lainnya) ...

} else {
    die("Akses tidak diizinkan.");
}

$conn->close();