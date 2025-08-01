<?php
    require("connection.php");

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Gunakan prepared statement
    $query = "SELECT * FROM user WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameter ke query
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);

    // Ambil hasil query
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../view/index.php");
        exit();
    } else {
        echo "<script>alert('Login gagal: email atau password salah'); window.location.href = '../view/login.php';</script>";
    }
?>
