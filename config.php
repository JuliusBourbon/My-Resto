<?php
// Ambil protokol (http atau https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Ambil nama host (localhost atau domain)
$host = $_SERVER['HTTP_HOST'];

// Ambil path folder project (jika pakai subfolder)
$project_folder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// Gabungkan semuanya jadi satu base_url
$base_url = $protocol . $host . $project_folder;
