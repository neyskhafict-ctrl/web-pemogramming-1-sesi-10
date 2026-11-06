<?php

require_once "../config/auth.php";
require_once "../config/koneksi.php";

$query = "SELECT * FROM mahasiswa ORDER BY id DESC";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            color: #1e3a5f;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #1e3a5f;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .edit {
            color: #2563eb;
        }

        .delete {
            color: #dc2626;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #1e3a5f;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Data Mahasiswa</h2>

    <p>Berikut adalah daftar mahasiswa yang tersimpan.</p>

    <a href="tambah.php" class="btn">+ Tambah Mahasiswa</a>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php if ($result && $result->num_rows > 0): ?>

            <?php $no = 1; ?>

            <?php while ($row = $result->fetch_assoc()): ?>

                <tr>
                    <td><?= $no++; ?></td>

                    <td><?= htmlspecialchars($row["nim"]); ?></td>

                    <td><?= htmlspecialchars($row["nama"]); ?></td>

                    <td><?= htmlspecialchars($row["program_studi"]); ?></td>

                    <td><?= htmlspecialchars($row["email"]); ?></td>

                    <td>
                        <a class="edit"
                           href="edit.php?id=<?= $row["id"]; ?>">
                           Edit
                        </a>

                        |

                        <a class="delete"
                           href="hapus.php?id=<?= $row["id"]; ?>"
                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                           Hapus
                        </a>
                    </td>
                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="6" style="text-align:center;">
                    Belum ada data mahasiswa.
                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

    <a href="../pages/dashboard.php" class="back">
        ← Kembali ke Dashboard
    </a>

</div>

</body>
</html>

<?php
$conn->close();
?>