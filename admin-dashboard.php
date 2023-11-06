<?php
session_start();
require('config.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Tampilkan data peserta dari tb_pendaftaran
$sql = "SELECT * FROM tb_pendaftaran";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style-admindb.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="konoha.png" alt="Logo">
        </div>
        <ul class="menu">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Data Peserta</a></li>
            <li><a href="admin-logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Welcome, Admin</h1>
        <h2>Data Peserta Pendaftaran</h2>
        <table>
            <tr>
                <th>ID Pendaftaran</th>
                <th>Nama Peserta</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
                <!-- Tambahkan kolom lain sesuai dengan kebutuhan -->
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_pendaftaran'] . "</td>";
                echo "<td>" . $row['nm_peserta'] . "</td>";
                echo "<td>" . $row['jk'] . "</td>";
                // Tambahkan kolom lain sesuai dengan kebutuhan

                // Tombol Detail
                // echo '<td><a href="detail.php?id=' . $row['id_pendaftaran'] . '">Detail</a></td>';
                // // Tombol Hapus
                // echo '<td><a href="hapus.php?id=' . $row['id_pendaftaran'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</a></td>';
                echo '<td><a href="detail.php?id=' . $row['id_pendaftaran'] . '">Detail</a> | <a href="hapus.php?id=' . $row['id_pendaftaran'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</a></td>';

                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
