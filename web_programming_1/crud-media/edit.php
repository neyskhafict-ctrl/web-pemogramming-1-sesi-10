<?php
require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

$id = (int) ($_GET["id"] ?? 0);
if ($id <= 0) {
    die("ID tidak valid.");
}

$stmt = $conn->prepare(
    "SELECT id, nim, nama, program_studi, email, foto, audio, dokumen
     FROM mahasiswa WHERE id = ? LIMIT 1"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$mahasiswa = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$mahasiswa) {
    die("Data mahasiswa tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Media</title>
    <link rel="stylesheet" href="../assets/css/media.css">
</head>
<body>
<header class="page-header"><div class="wrap">
    <p class="eyebrow">WEB PROGRAMMING 1 · MODUL 10</p>
    <h1>Edit Data Media</h1>
    <p>File baru bersifat opsional. Kosongkan input file untuk mempertahankan media lama.</p>
</div></header>
<nav class="main-nav">
    <a href="../pages/dashboard.php">Dashboard</a>
    <a href="../crud/index.php">CRUD Mahasiswa</a>
    <a class="active" href="index.php">CRUD Media</a>
    <a href="../proses/logout.php" class="logout">Logout</a>
</nav>
<main class="wrap"><section class="panel form-panel">
    <h2>Perbarui Data Mahasiswa</h2>
    <form class="crud-form" data-media-form data-require-foto="false"
          action="../proses/crud-media/update.php" method="POST"
          enctype="multipart/form-data" novalidate>
        <input type="hidden" name="id" value="<?= (int) $mahasiswa["id"]; ?>">

        <label for="nim">NIM</label>
        <input id="nim" name="nim" type="text" value="<?= htmlspecialchars($mahasiswa["nim"]); ?>" required>
        <small class="form-error" id="errorNim"></small>

        <label for="nama">Nama Lengkap</label>
        <input id="nama" name="nama" type="text" value="<?= htmlspecialchars($mahasiswa["nama"]); ?>" required>
        <small class="form-error" id="errorNama"></small>

        <label for="program_studi">Program Studi</label>
        <input id="program_studi" name="program_studi" type="text" value="<?= htmlspecialchars($mahasiswa["program_studi"]); ?>" required>
        <small class="form-error" id="errorProdi"></small>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= htmlspecialchars($mahasiswa["email"]); ?>" required>
        <small class="form-error" id="errorEmail"></small>

        <div class="current-media">
            <strong>Foto saat ini</strong>
            <?php if (!empty($mahasiswa["foto"])): ?>
                <img class="media-preview-image" src="../uploads/images/<?= rawurlencode($mahasiswa["foto"]); ?>" alt="Foto saat ini">
            <?php else: ?><p>Belum ada foto.</p><?php endif; ?>
        </div>
        <label for="foto">Ganti Foto (opsional, JPG/PNG/WEBP, maksimal 2 MB)</label>
        <input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/webp">
        <small class="form-error" id="errorFoto"></small>
        <img id="previewFoto" class="media-preview-image" alt="Preview foto baru" hidden>

        <div class="current-media">
            <strong>Audio saat ini</strong>
            <?php if (!empty($mahasiswa["audio"])): ?>
                <audio controls preload="none"><source src="../uploads/audio/<?= rawurlencode($mahasiswa["audio"]); ?>"></audio>
            <?php else: ?><p>Belum ada audio.</p><?php endif; ?>
        </div>
        <label for="audio">Ganti Audio (opsional, MP3/WAV, maksimal 2 MB)</label>
        <input id="audio" name="audio" type="file" accept="audio/mpeg,audio/wav">
        <audio id="previewAudio" class="media-preview-audio" controls hidden></audio>

        <div class="current-media">
            <strong>Dokumen saat ini</strong>
            <?php if (!empty($mahasiswa["dokumen"])): ?>
                <a href="../uploads/documents/<?= rawurlencode($mahasiswa["dokumen"]); ?>" target="_blank" rel="noopener">Buka PDF</a>
            <?php else: ?><p>Belum ada dokumen.</p><?php endif; ?>
        </div>
        <label for="dokumen">Ganti Dokumen PDF (opsional, maksimal 2 MB)</label>
        <input id="dokumen" name="dokumen" type="file" accept="application/pdf">
        <p id="previewDokumen" class="file-hint">Belum ada dokumen baru dipilih.</p>

        <div class="form-actions">
            <button class="button" type="submit">Update Data Media</button>
            <a class="button-secondary" href="index.php">Batal</a>
        </div>
    </form>
</section></main>
<script src="../assets/js/media.js"></script>
</body>
</html>