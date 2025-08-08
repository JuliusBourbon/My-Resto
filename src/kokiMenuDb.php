<?php
require_once __DIR__ . '/connection.php';

$kategori = $conn->query("SELECT * FROM kategori_menu");
$menu = $conn->query("SELECT 
                        m.id_menu, 
                        m.nama, 
                        m.harga, 
                        m.status_ketersediaan, 
                        k.nama_kategori 
                    FROM 
                        menu m 
                    JOIN 
                        kategori_menu k ON m.id_kategori = k.id_kategori 
                    WHERE 
                        m.status_ketersediaan != 'Deleted' -- Perbaikan di sini
                    ORDER BY 
                        m.nama ASC;");

$menu_list = $menu->fetch_all(MYSQLI_ASSOC);

?>