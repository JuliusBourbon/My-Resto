<?php
	$host = "localhost";
	$user = "root";
	$passw = "";
	$db = "myresto";
	$conn = mysqli_connect($host, $user, $passw, $db);

    // Cek koneksi
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
?>