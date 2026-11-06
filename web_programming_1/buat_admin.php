<?php
require_once "config/koneksi.php";

$nama = "Administrator";
$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$role = "admin";

$stmt = $conn->prepare(
    "INSERT INTO users (nama, username, password, role)
     VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("ssss", $nama, $username, $password, $role);

if ($stmt->execute()) {
    echo "Akun admin berhasil dibuat!";
} else {
    echo "Gagal: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>