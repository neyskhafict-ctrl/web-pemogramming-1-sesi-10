<?php
require_once "../config/auth.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Web Programming 1</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        header {
            background: #1e3a5f;
            color: white;
            padding: 25px 35px;
        }

        nav {
            background: white;
            padding: 18px 35px;
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            box-shadow: 0 2px 5px #ddd;
        }

        nav a {
            text-decoration: none;
            color: #1e3a5f;
            font-weight: bold;
        }

        main {
            padding: 35px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .logout {
            color: #dc2626;
        }
    </style>
</head>

<body>

<header>
    <h1>Dashboard Web Programming 1</h1>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION["nama"]); ?>!</p>
</header>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="../crud/index.php">Data Mahasiswa</a>
    <a href="../crud-media/index.php">CRUD Media</a>
    <a href="../proses/logout.php" class="logout">Logout</a>
</nav>

<main>

    <div class="card">
        <h2>Selamat Datang!</h2>
        <p>Login berhasil. Kamu sekarang berada di Project Hub.</p>

        <p>Username:
            <?= htmlspecialchars($_SESSION["username"]); ?>
        </p>

        <p>Role:
            <?= htmlspecialchars($_SESSION["role"]); ?>
        </p>
    </div>

    <div class="card">
        <h2>Manajemen Data Mahasiswa</h2>
        <p>Kelola data mahasiswa melalui fitur CRUD.</p>

        <a href="../crud/index.php">Buka Data Mahasiswa →</a>
        <p><a href="../crud-media/index.php">Buka CRUD Media →</a></p>
    </div>

</main>

</body>
</html>