<?php
require_once __DIR__ . '/connection.php';

$kategori = $conn->query("SELECT * FROM kategori_menu");


$menu = $conn->query("SELECT * FROM menu");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_menu'], $_POST['status_ketersediaan'])) {
        $id_menu = (int) $_POST['id_menu'];
        $status  = $conn->real_escape_string($_POST['status_ketersediaan']);

        $stmt = $conn->prepare("UPDATE menu SET status_ketersediaan = ? WHERE id_menu = ?");
        if ($stmt) {
            $stmt->bind_param("si", $status, $id_menu);
            $stmt->execute();
            $stmt->close();
        }
    }
}
