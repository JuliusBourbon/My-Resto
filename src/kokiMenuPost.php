<?php
require_once __DIR__ . '/connection.php';

// 2. Pastikan request datang dari method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 3. Validasi dan ambil data dari form
    if (
        isset($_POST['nama'], $_POST['harga'], $_POST['id_kategori'], $_POST['status_ketersediaan']) &&
        !empty($_POST['nama']) &&
        !empty($_POST['harga']) &&
        !empty($_POST['id_kategori'])
    ) {
        
        // Ambil dan bersihkan data
        $nama = $_POST['nama'];
        $harga = (float) $_POST['harga']; // Casting harga ke tipe float
        $id_kategori = (int) $_POST['id_kategori']; // Casting id_kategori ke tipe integer
        $status_ketersediaan = $_POST['status_ketersediaan'];

        // 4. Siapkan query INSERT menggunakan prepared statement
        $sql = "INSERT INTO menu (nama, harga, id_kategori, status_ketersediaan) VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);

        // 5. Periksa apakah statement berhasil disiapkan
        if ($stmt) {
            $stmt->bind_param("sdis", $nama, $harga, $id_kategori, $status_ketersediaan);

            // 6. Eksekusi statement dan berikan feedback
            if ($stmt->execute()) {
                header("Location: ../koki-menu");
            } else {
                // Jika gagal eksekusi
                echo "Error: Gagal menambahkan menu. " . $stmt->error;
            }
            
            // Tutup statement
            $stmt->close();

        } else {
            // Jika statement gagal disiapkan
            echo "Error: Gagal menyiapkan statement. " . $conn->error;
        }

    } else {
        // Jika ada field yang tidak diisi
        die("Error: Semua field wajib diisi.");
    }

} else {
    // Jika halaman diakses langsung (bukan via POST)
    die("Akses tidak diizinkan.");
}

// Tutup koneksi database
$conn->close();

// Hentikan eksekusi skrip setelah redirect
exit();