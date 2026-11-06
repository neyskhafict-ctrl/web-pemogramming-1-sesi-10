<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    $projectPath = str_replace("\\", "/", dirname(__DIR__));
    $documentRoot = isset($_SERVER["DOCUMENT_ROOT"])
        ? str_replace("\\", "/", realpath($_SERVER["DOCUMENT_ROOT"]))
        : "";

    $baseUrl = "";
    if ($documentRoot !== "" && strpos($projectPath, $documentRoot) === 0) {
        $baseUrl = substr($projectPath, strlen($documentRoot));
    }

    header("Location: " . rtrim($baseUrl, "/") . "/index.php");
    exit;
}
?>