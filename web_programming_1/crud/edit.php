<?php
require_once '../config/koneksi.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    header("Location: index.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nim = trim($_POST['nim']);
    $nama = trim($_POST['nama']);
    $program_studi = trim($_POST['program_studi']);
    $email = trim($_POST['email']);

    if ($nim === '' || $nama === '' ||
        $program_studi === '' || $email === '') {
        $error = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } else {
        $stmt = mysqli_prepare($conn,
            "UPDATE mahasiswa SET nim=?, nama=?, program_studi=?, email=? WHERE id=?");

        mysqli_stmt_bind_param(
            $stmt, "ssssi",
            $nim, $nama, $program_studi, $email, $id
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?status=updated");
            exit;
        } else {
            $error = "Gagal memperbarui data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
</head>
<body>

<h2>Edit Data Mahasiswa</h2>

<?php if (isset($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>NIM</label><br>
    <input type="text" name="nim"
        value="<?= htmlspecialchars($data['nim']) ?>" required><br><br>

    <label>Nama Lengkap</label><br>
    <input type="text" name="nama"
        value="<?= htmlspecialchars($data['nama']) ?>" required><br><br>

    <label>Program Studi</label><br>
    <input type="text" name="program_studi"
        value="<?= htmlspecialchars($data['program_studi']) ?>" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email"
        value="<?= htmlspecialchars($data['email']) ?>" required><br><br>

    <button type="submit" name="simpan">Simpan Perubahan</button>
</form>

<a href="index.php">Kembali</a>

</body>
</html>