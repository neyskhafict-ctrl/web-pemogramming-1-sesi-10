<?php
require_once __DIR__ . "/../../config/auth.php";
require_once __DIR__ . "/../../config/koneksi.php";
require_once __DIR__ . "/../../config/media_helper.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../crud-media/index.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);
$nim = trim($_POST["nim"] ?? "");
$nama = trim($_POST["nama"] ?? "");
$program_studi = trim($_POST["program_studi"] ?? "");
$email = trim($_POST["email"] ?? "");

if ($id <= 0 || $nim === "" || $nama === "" || $program_studi === "" || $email === "") {
    die("Data update tidak valid.");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Format email tidak valid.");
}

$stmtOld = $conn->prepare(
    "SELECT foto, audio, dokumen FROM mahasiswa WHERE id = ? LIMIT 1"
);
$stmtOld->bind_param("i", $id);
$stmtOld->execute();
$lama = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$lama) {
    die("Data tidak ditemukan.");
}

$rootUpload = __DIR__ . "/../../uploads";
$imageDir = $rootUpload . "/images";
$audioDir = $rootUpload . "/audio";
$documentDir = $rootUpload . "/documents";

$allowedImage = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
$allowedAudio = [
    "audio/mpeg" => "mp3", "audio/wav" => "wav", "audio/x-wav" => "wav",
    "audio/wave" => "wav", "audio/vnd.wave" => "wav", "audio/x-pn-wav" => "wav"
];
$allowedDocument = ["application/pdf" => "pdf"];
$maxSize = 2 * 1024 * 1024;

$fotoBaru = $audioBaru = $dokumenBaru = null;

try {
    $fotoBaru = uploadMedia($_FILES["foto"] ?? [], $allowedImage, $maxSize, $imageDir, "img");
    $audioBaru = uploadMedia($_FILES["audio"] ?? [], $allowedAudio, $maxSize, $audioDir, "aud");
    $dokumenBaru = uploadMedia($_FILES["dokumen"] ?? [], $allowedDocument, $maxSize, $documentDir, "doc");

    $fotoFinal = $fotoBaru ?? $lama["foto"];
    $audioFinal = $audioBaru ?? $lama["audio"];
    $dokumenFinal = $dokumenBaru ?? $lama["dokumen"];

    $stmt = $conn->prepare(
        "UPDATE mahasiswa
         SET nim = ?, nama = ?, program_studi = ?, email = ?,
             foto = ?, audio = ?, dokumen = ?
         WHERE id = ?"
    );
    $stmt->bind_param(
        "sssssssi", $nim, $nama, $program_studi, $email,
        $fotoFinal, $audioFinal, $dokumenFinal, $id
    );

    if (!$stmt->execute()) {
        throw new RuntimeException("Update database gagal.");
    }
    $stmt->close();

    if ($fotoBaru !== null) hapusMediaJikaAda($lama["foto"], $imageDir);
    if ($audioBaru !== null) hapusMediaJikaAda($lama["audio"], $audioDir);
    if ($dokumenBaru !== null) hapusMediaJikaAda($lama["dokumen"], $documentDir);

    $conn->close();
    header("Location: ../../crud-media/index.php?status=update");
    exit;
} catch (Throwable $e) {
    hapusMediaJikaAda($fotoBaru, $imageDir);
    hapusMediaJikaAda($audioBaru, $audioDir);
    hapusMediaJikaAda($dokumenBaru, $documentDir);
    http_response_code(400);
    die("Proses update gagal: " . htmlspecialchars($e->getMessage()));
}
?>