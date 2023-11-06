<?php
session_start();
require('config.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_pendaftaran = $_GET['id'];
    // Query untuk menghapus data peserta berdasarkan ID
    $sql = "DELETE FROM tb_pendaftaran WHERE id_pendaftaran = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id_pendaftaran);

    if ($stmt->execute()) {
        // Data berhasil dihapus
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "Gagal menghapus data peserta. Silakan coba lagi.";
    }

    $stmt->close();
} else {
    echo "ID Pendaftaran tidak valid.";
}
?>
