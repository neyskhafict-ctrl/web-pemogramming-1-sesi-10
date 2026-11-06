<?php
require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

$sql = "SELECT id, nim, nama, program_studi, email, foto, audio, dokumen
        FROM mahasiswa ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Media - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/media.css">
</head>
<body>
<header class="page-header">
    <div class="wrap">
        <p class="eyebrow">WEB PROGRAMMING 1 · MODUL 10</p>
        <h1>CRUD Media</h1>
        <p>Kelola data mahasiswa, foto, audio, dan dokumen PDF.</p>
    </div>
</header>
<nav class="main-nav">
    <a href="../pages/dashboard.php">Dashboard</a>
    <a href="../crud/index.php">CRUD Mahasiswa</a>
    <a class="active" href="index.php">CRUD Media</a>
    <a href="../proses/logout.php" class="logout">Logout</a>
</nav>
<main class="wrap">
    <section class="panel">
        <div class="toolbar">
            <div>
                <h2>Daftar Data Media</h2>
                <p>Data lama tanpa media tetap ditampilkan.</p>
            </div>
            <a class="button" href="tambah.php">+ Tambah Data Media</a>
        </div>
        <input class="search" type="search" id="searchMedia"
               placeholder="Cari NIM, nama, program studi, atau email...">
        <div class="table-scroll">
        <table id="mediaTable">
            <thead>
                <tr>
                    <th>No</th><th>Foto</th><th>NIM</th><th>Nama</th>
                    <th>Program Studi</th><th>Email</th><th>Audio</th>
                    <th>Dokumen</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <?php if (!empty($row["foto"])): ?>
                            <img class="table-photo"
                                 src="../uploads/images/<?= rawurlencode($row["foto"]); ?>"
                                 alt="Foto <?= htmlspecialchars($row["nama"]); ?>">
                        <?php else: ?>-<?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row["nim"]); ?></td>
                    <td><?= htmlspecialchars($row["nama"]); ?></td>
                    <td><?= htmlspecialchars($row["program_studi"]); ?></td>
                    <td><?= htmlspecialchars($row["email"]); ?></td>
                    <td>
                        <?php if (!empty($row["audio"])): ?>
                            <audio controls preload="none" class="table-audio">
                                <source src="../uploads/audio/<?= rawurlencode($row["audio"]); ?>">
                            </audio>
                        <?php else: ?>-<?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($row["dokumen"])): ?>
                            <a href="../uploads/documents/<?= rawurlencode($row["dokumen"]); ?>"
                               target="_blank" rel="noopener">Buka PDF</a>
                        <?php else: ?>-<?php endif; ?>
                    </td>
                    <td class="actions">
                        <a href="edit.php?id=<?= (int) $row["id"]; ?>">Edit</a>
                        <form action="../proses/crud-media/hapus.php" method="POST"
                              class="media-delete-form">
                            <input type="hidden" name="id" value="<?= (int) $row["id"]; ?>">
                            <button type="submit" class="button-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" class="empty">Belum ada data mahasiswa.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
        <a class="back-link" href="../pages/dashboard.php">← Kembali ke Dashboard</a>
    </section>
</main>
<script src="../assets/js/media.js"></script>
</body>
</html>
<?php $conn->close(); ?>