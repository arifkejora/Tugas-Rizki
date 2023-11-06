<?php
session_start();
require('config.php');

$loginStatus = ""; // Variabel untuk menyimpan pesan notifikasi

if (isset($_SESSION['admin_id'])) {
    header("Location: admin-dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi dan cek username dan password di database
    $sql = "SELECT id_admin FROM tb_admin WHERE username = ? AND password = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id);
        $stmt->fetch();
        $_SESSION['admin_id'] = $admin_id;
        header("Location: admin-dashboard.php");
        exit();
    } else {
        $loginStatus = "Login gagal. Periksa kembali username dan password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="style-autentikasi.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <form method="POST" action="admin-login.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <div class="input-container">
                    <input type="text" id="username" name="username" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <div class="input-container">
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <input type="submit" value="Login">
        </form>
        
        <!-- Notifikasi hasil login -->
        <?php
        if (!empty($loginStatus)) {
            echo "<p>$loginStatus</p>";
        }
        ?>
    </div>
</body>
</html>
