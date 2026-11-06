<?php

require_once "../config/auth.php";
require_once "../config/koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nim = trim($_POST["nim"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $program_studi = trim($_POST["program_studi"] ?? "");
    $email = trim($_POST["email"] ?? "");

    // Validasi input tidak boleh kosong
    if ($nim === "" || $nama === "" ||
        $program_studi === "" || $email === "") {

        $error = "Semua data wajib diisi!";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Format email tidak valid!";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO mahasiswa
            (nim, nama, program_studi, email)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssss",
            $nim,
            $nama,
            $program_studi,
            $email
        );

        if ($stmt->execute()) {

            $stmt->close();
            $conn->close();

            header("Location: index.php?status=berhasil");
            exit;

        } else {

            $error = "Gagal menyimpan data: " . $stmt->error;

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Mahasiswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h2 {
            color: #1e3a5f;
        }

        label {
            display: block;
            margin-top: 18px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            margin-top: 25px;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .error {
            color: #b91c1c;
            background: #fee2e2;
            padding: 12px;
            border-radius: 6px;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #2563eb;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Tambah Data Mahasiswa</h2>

    <p>Silakan isi formulir berikut dengan lengkap.</p>

    <?php if ($error !== ""): ?>
        <div class="error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" id="formMahasiswa">

        <label>NIM</label>
        <input type="text" name="nim"
            placeholder="Masukkan NIM"
            value="<?= htmlspecialchars($_POST["nim"] ?? ""); ?>"
            required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama"
            placeholder="Masukkan nama lengkap"
            value="<?= htmlspecialchars($_POST["nama"] ?? ""); ?>"
            required>

        <label>Program Studi</label>
        <input type="text" name="program_studi"
            placeholder="Masukkan program studi"
            value="<?= htmlspecialchars($_POST["program_studi"] ?? ""); ?>"
            required>

        <label>Email</label>
        <input type="email" name="email"
            placeholder="contoh@email.com"
            value="<?= htmlspecialchars($_POST["email"] ?? ""); ?>"
            required>

        <button type="submit">Simpan Data</button>

    </form>

    <a href="index.php" class="back">
        ← Kembali ke Data Mahasiswa
    </a>

</div>

<script>
document.getElementById("formMahasiswa")
.addEventListener("submit", function(event) {

    const nim = document.querySelector('[name="nim"]').value.trim();
    const nama = document.querySelector('[name="nama"]').value.trim();
    const prodi = document.querySelector('[name="program_studi"]').value.trim();
    const email = document.querySelector('[name="email"]').value.trim();

    const polaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (nim === "" || nama === "" ||
        prodi === "" || email === "") {

        alert("Semua data wajib diisi!");
        event.preventDefault();
        return;
    }

    if (!polaEmail.test(email)) {

        alert("Format email tidak valid! Contoh: nama@email.com");
        event.preventDefault();
        return;
    }

});
</script>

</body>
</html>