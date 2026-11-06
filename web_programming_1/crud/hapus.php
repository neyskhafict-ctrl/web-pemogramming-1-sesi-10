<?php
require_once '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?status=hapus");
        exit;
    }

    echo "Gagal menghapus data.";
} else {
    header("Location: index.php");
    exit;
}
?>