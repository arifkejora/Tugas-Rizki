<?php
session_start();
require('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_akunsiswa = $_POST['username_akunsiswa'];
    $password_akunsiswa = $_POST['password_akunsiswa'];

    // Validasi data yang dimasukkan (contoh: pastikan data tidak kosong)
    if (empty($username_akunsiswa) || empty($password_akunsiswa)) {
        $registrationStatus = "Isi semua kolom dengan benar.";
    } else {
        // Lakukan validasi lain sesuai kebutuhan

        // Selanjutnya, masukkan data ke dalam tabel tb_akunsiswa
        $sql = "INSERT INTO tb_akunsiswa (username_akunsiswa, password_akunsiswa) VALUES (?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $username_akunsiswa, $password_akunsiswa);

        if ($stmt->execute()) {
            $registrationStatus = "Registrasi berhasil. Silakan login.";
        } else {
            $registrationStatus = "Gagal melakukan registrasi. Coba lagi.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Siswa Registration</title>
    <link rel="stylesheet" type="text/css" href="style-autentikasi.css">
</head>
<body>
    <div class="login-container">
        <h1>Siswa Registration</h1>
        <form method="POST" action="siswa-register.php">
            <div class="form-group">
                <label for="username_akunsiswa">Username:</label>
                <div class="input-container">
                    <input type="text" id="username_akunsiswa" name="username_akunsiswa" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password_akunsiswa">Password:</label>
                <div class="input-container">
                    <input type="password" id="password_akunsiswa" name="password_akunsiswa" required>
                </div>
            </div>
            <input type="submit" value="Register">
        </form>
        
        <!-- Notifikasi hasil registrasi -->
        <?php
        if (isset($registrationStatus)) {
            echo "<p>$registrationStatus</p>";
        }
        ?>
    </div>
</body>
</html>

