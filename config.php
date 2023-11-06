<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "db_psb";

// Buat koneksi ke database
$connection = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($connection->connect_error) {
    die("Koneksi ke database gagal: " . $connection->connect_error);
}
?>
