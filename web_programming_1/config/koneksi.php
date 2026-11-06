<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "web_programming_1";

// Membuat koneksi database
$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>