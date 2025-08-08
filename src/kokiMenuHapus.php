<?php
// Sertakan file koneksi
require_once __DIR__ . '/connection.php';

// Pastikan request datang dari method POST dan id_menu ada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_menu'])) {
    
    // Ambil id_menu dan siapkan status baru
    $id_menu = (int) $_POST['id_menu'];
    $status_baru = 'Deleted';

    // Siapkan query UPDATE menggunakan prepared statement
    $sql = "UPDATE menu SET status_ketersediaan = ? WHERE id_menu = ?";
    
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter ke statement: "s" untuk string, "i" untuk integer
        $stmt->bind_param("si", $status_baru, $id_menu);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Jika berhasil, redirect kembali ke halaman menu koki
            // Anda bisa menambahkan parameter untuk notifikasi jika perlu
            header("Location: ../koki-menu");
        } else {
            // Jika gagal eksekusi
            echo "Error: Gagal menghapus menu. " . $stmt->error;
        }
        
        // Tutup statement
        $stmt->close();

    } else {
        // Jika statement gagal disiapkan
        echo "Error: Gagal menyiapkan statement. " . $conn->error;
    }

} else {
    // Jika akses tidak sah
    die("Akses tidak diizinkan.");
}

// Tutup koneksi
$conn->close();
exit();