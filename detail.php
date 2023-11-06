<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta</title>
    <link rel="stylesheet" type="text/css" href="style-detail.css">
</head>
<body>
    <div class="container">
        <?php
        session_start();
        require('config.php');

        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin-login.php");
            exit();
        }

        if (isset($_GET['id'])) {
            $id_pendaftaran = $_GET['id'];
            // Query untuk mengambil detail data peserta berdasarkan ID
            $sql = "SELECT * FROM tb_pendaftaran WHERE id_pendaftaran = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $id_pendaftaran);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Tampilkan detail data peserta
                echo "<h1>Detail Peserta</h1>";
                echo "<p>ID Pendaftaran: " . $row['id_pendaftaran'] . "</p>";
                echo "<p>Nama Peserta: " . $row['nm_peserta'] . "</p>";
                echo "<p>Tanggal Pendaftaran: " . $row['tgl_pendaftaran'] . "</p>";
                echo "<p>Tahun Ajaran: " . $row['th_ajaran'] . "</p>";
                echo "<p>Jurusan: " . $row['jurusan'] . "</p>";
                echo "<p>Tempat, Tanggal Lahir: " . $row['tmpt_lahir'] . ", " . $row['tgl_lahir'] . "</p>";
                echo "<p>Jenis Kelamin: " . $row['jk'] . "</p>";
                echo "<p>Agama: " . $row['agama'] . "</p>";
                echo "<p>Alamat Peserta: " . $row['alt_peserta'] . "</p>";
                // Tambahkan detail lain sesuai dengan kebutuhan
            } else {
                echo "Data peserta tidak ditemukan.";
            }

            $stmt->close();
        } else {
            echo "ID Pendaftaran tidak valid.";
        }
        ?>
        <div class="button">
            <a href="admin-dashboard.php">Kembali</a>
        </div>
    </div>
</body>
</html>
