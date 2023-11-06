<?php
session_start();
require('config.php');

if (!isset($_SESSION['akunsiswa_id']) || !isset($_SESSION['akunsiswa_username'])) {
    header("Location: siswa-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $th_ajaran = $_POST['th_ajaran'];
    $jurusan = $_POST['jurusan'];
    $nm_peserta = $_POST['nm_peserta'];
    $tmpt_lahir = $_POST['tmpt_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jk = $_POST['jk'];
    $agama = $_POST['agama'];
    $alt_peserta = $_POST['alt_peserta'];

    $akunsiswa_id = $_SESSION['akunsiswa_id'];
    $akunsiswa_username = $_SESSION['akunsiswa_username'];
    $tgl_pendaftaran = date('Y-m-d'); // Tanggal saat ini

    // Validasi apakah data sudah ada
    $sql_check = "SELECT id_pendaftaran FROM tb_pendaftaran WHERE id_akunsiswa = ? AND th_ajaran = ?";
    $stmt_check = $connection->prepare($sql_check);
    $stmt_check->bind_param("ss", $akunsiswa_id, $th_ajaran);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Data sudah ada, berikan pesan ke pengguna
        $insertStatus = "Anda sudah mendaftarkan diri untuk tahun ajaran ini.";
    } else {
        // Data belum ada, masukkan data ke dalam tabel tb_pendaftaran
        $sql = "INSERT INTO tb_pendaftaran (id_akunsiswa, tgl_pendaftaran, th_ajaran, jurusan, nm_peserta, tmpt_lahir, tgl_lahir, jk, agama, alt_peserta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssssssss", $akunsiswa_id, $tgl_pendaftaran, $th_ajaran, $jurusan, $nm_peserta, $tmpt_lahir, $tgl_lahir, $jk, $agama, $alt_peserta);

        if ($stmt->execute()) {
            // Jika insert berhasil, berikan pesan ke pengguna
            $insertStatus = "Data berhasil disimpan.";
        } else {
            $insertStatus = "Gagal menyimpan data. Silakan coba lagi.";
        }

        $stmt->close();
    }

    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Online</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<section class="box-formulir">
    <h2>Formulir Pendaftaran Siswa Baru SMK</h2>
    <h2>Ini <?php echo $_SESSION['akunsiswa_username']; ?>, ID Kamu, <?php echo $_SESSION['akunsiswa_id']; ?></h2>
    <a href="siswa-logout.php" class="btn-logout">Logout</a>
</section>

    <form action="" method="post">
        <div class="box">
            <table border="0" class="table-form">
                <tr>
                    <td>Tahun Ajaran</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="th_ajaran" class="input-control" value="2024/2025" readonly>
                    </td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td>
                        <select class="select-control" name="jurusan">
                            <option value="">--pilih--</option>
                            <option value="Ilmu Pengetahuan Alam">Ilmu Pengetahuan Alam</option>
                            <option value="Ilmu Pengetahuan Sosial">Ilmu Pengetahuan Sosial</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box">
            <h3>Data Diri Calon Siswa</h3>
            <table border="0" class="table-form">
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="nm_peserta" class="input-control">
                    </td>
                </tr>
                <tr>
                    <td>Tempat Lahir</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="tmpt_lahir" class="input-control">
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td>
                        <input type="date" name="tgl_lahir" class="input-control">
                    </td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td class="radio-container">
                        <label>
                            <input type="radio" name="jk" class="input-control" value="Laki-laki"> Laki-Laki
                        </label>
                        <label>
                            <input type="radio" name="jk" class="input-control" value="Perempuan"> Perempuan
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td>
                        <select class="select-control" name="agama">
                            <option value="">--pilih--</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Budha">Budha</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Khatolik">Khatolik</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Alamat Lengkap</td>
                    <td>:</td>
                    <td>
                        <textarea class="input-control" name="alt_peserta"></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" class="btn-daftar" value="Daftar Sekarang">
                    </td>

                </tr>
            </table>
        </div>
    </form>
</body>
</html>
