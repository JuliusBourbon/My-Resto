<?php
session_start();

function requireRole($role) {
    if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
        header("Location: /My-Resto/login");
        exit;
    }

    if ($_SESSION['role'] !== $role) {
        echo "<script>alert('Akses ditolak'); window.location.href = '/My-Resto/login';</script>";
        exit;
    }
}

function requireLogin() {
    if (!isset($_SESSION['email'])) {
        header("Location: /My-Resto/login");
        exit;
    }
}
