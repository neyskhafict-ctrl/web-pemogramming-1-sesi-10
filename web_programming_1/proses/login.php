<?php

session_start();

require_once "../config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
    header("Location: ../index.php?error=1");
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, nama_lengkap, username, password_hash, role
     FROM users
     WHERE username = ?
     LIMIT 1"
);

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user["password_hash"])) {

    session_regenerate_id(true);

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["nama"] = $user["nama_lengkap"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["role"] = $user["role"];

    header("Location: ../pages/dashboard.php");
    exit;

} else {

    header("Location: ../index.php?error=1");
    exit;

}

?>