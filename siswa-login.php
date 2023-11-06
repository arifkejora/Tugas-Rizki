<?php
session_start();
require('config.php');

if (isset($_SESSION['akunsiswa_id'])) {
    header("Location: siswa-dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username_akunsiswa'];
    $password = $_POST['password_akunsiswa'];

    // Validasi dan cek username dan password di database
    $sql = "SELECT id_akunsiswa, username_akunsiswa FROM tb_akunsiswa WHERE username_akunsiswa = ? AND password_akunsiswa = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($akunsiswa_id, $akunsiswa_username);
        $stmt->fetch();
        $_SESSION['akunsiswa_id'] = $akunsiswa_id;
        $_SESSION['akunsiswa_username'] = $akunsiswa_username;
        $loginStatus = "Login berhasil.";
        header("Location: siswa-dashboard.php");
        // Tambahkan validasi atau logika tambahan jika diperlukan
    } else {
        $loginStatus = "Login gagal. Periksa kembali username dan password.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Siswa Login</title>
    <link rel="stylesheet" type="text/css" href="style-autentikasi.css">
</head>
<body>
    <div class="login-container">
        <h1>Siswa Login</h1>
        <form method="POST" action="siswa-login.php">
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
            <input type="submit" value="Login">
        </form>
        
        <!-- Notifikasi hasil login -->
        <?php
        if (isset($loginStatus)) {
            echo "<p>$loginStatus</p>";
        }
        ?>
    </div>
</body>
</html>

