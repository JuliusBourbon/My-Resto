<?php
require('connection.php');
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo "<script>alert('Email dan password harus diisi'); window.location.href = '../view/login.php';</script>";
    exit;
}

$query = "SELECT * FROM user WHERE email = ? AND password = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $user['email'];
    $_SESSION['nama'] = $user['nama']; 
    $_SESSION['role'] = $user['role'];

    // Redirect sesuai role
    switch ($user['role']) {
        case 'pelayan':
            header("Location: ../meja");
            break;
        case 'koki':
            header("Location: ../koki-menu");
            break;
        case 'kasir':
            header("Location: ../pembayaran");
            break;
        default:
            echo "<script>alert('Role tidak dikenali'); window.location.href = '../login';</script>";
            break;
    }
    exit();
} else {
    echo "<script>alert('Login gagal: email atau password salah'); window.location.href = '../login';</script>";
}
?>
