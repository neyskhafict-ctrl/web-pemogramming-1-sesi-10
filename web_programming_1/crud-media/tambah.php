<?php
require_once __DIR__ . "/../config/auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Media</title>
    <link rel="stylesheet" href="../assets/css/media.css">
</head>
<body>
<header class="page-header"><div class="wrap">
    <p class="eyebrow">WEB PROGRAMMING 1 · MODUL 10</p>
    <h1>Tambah Data Media</h1>
    <p>Lengkapi data mahasiswa dan pilih file media yang diperlukan.</p>
</div></header>
<nav class="main-nav">
    <a href="../pages/dashboard.php">Dashboard</a>
    <a href="../crud/index.php">CRUD Mahasiswa</a>
    <a class="active" href="index.php">CRUD Media</a>
    <a href="../proses/logout.php" class="logout">Logout</a>
</nav>
<main class="wrap"><section class="panel form-panel">
    <h2>Formulir Data Mahasiswa</h2>
    <form class="crud-form" data-media-form data-require-foto="true"
          action="../proses/crud-media/tambah.php" method="POST"
          enctype="multipart/form-data" novalidate>
        <label for="nim">NIM</label>
        <input id="nim" name="nim" type="text" required>
        <small class="form-error" id="errorNim"></small>

        <label for="nama">Nama Lengkap</label>
        <input id="nama" name="nama" type="text" required>
        <small class="form-error" id="errorNama"></small>

        <label for="program_studi">Program Studi</label>
        <input id="program_studi" name="program_studi" type="text" required>
        <small class="form-error" id="errorProdi"></small>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>
        <small class="form-error" id="errorEmail"></small>

        <label for="foto">Foto (wajib, JPG/PNG/WEBP, maksimal 2 MB)</label>
        <input id="foto" name="foto" type="file"
               accept="image/jpeg,image/png,image/webp" required>
        <small class="form-error" id="errorFoto"></small>
        <div class="media-preview-box">
            <strong>Preview Foto</strong>
            <img id="previewFoto" class="media-preview-image"
                 alt="Preview foto yang dipilih" hidden>
        </div>

        <label for="audio">Audio (opsional, MP3/WAV, maksimal 2 MB)</label>
        <input id="audio" name="audio" type="file" accept="audio/mpeg,audio/wav">
        <div class="media-preview-box">
            <strong>Preview Audio</strong>
            <audio id="previewAudio" class="media-preview-audio" controls hidden></audio>
        </div>

        <label for="dokumen">Dokumen PDF (opsional, maksimal 2 MB)</label>
        <input id="dokumen" name="dokumen" type="file" accept="application/pdf">
        <p id="previewDokumen" class="file-hint">Belum ada dokumen dipilih.</p>

        <div class="form-actions">
            <button class="button" type="submit">Simpan Data Media</button>
            <a class="button-secondary" href="index.php">Batal</a>
        </div>
    </form>
</section></main>
<script src="../assets/js/media.js"></script>
</body>
</html>