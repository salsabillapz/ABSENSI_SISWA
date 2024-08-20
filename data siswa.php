<?php
$servername = "localhost"; // Nama host
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "sekolah"; // Nama database

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data absensi
$sql = "SELECT * FROM absensi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa - Side Menu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #1d3557;
            padding: 20px;
            position: fixed;
            height: 100%;
            transition: all 0.3s;
        }

        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            border-bottom: 2px solid #457b9d;
            padding-bottom: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            font-size: 18px;
            color: #f1faee;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #457b9d;
            transform: translateX(10px);
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .main-content h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #1d3557;
        }

        .main-content p {
            font-size: 18px;
            line-height: 1.6;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Absensi Siswa</h2>
        <ul>
            <li><a href="data siswa.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Daftar Siswa</a></li>
            <li><a href="absensi.php"><i class="fas fa-clipboard-list"></i> Absensi</a></li>
            <li><a href="#"><i class="fas fa-file-alt"></i> Rekap Absensi</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Selamat datang di Absensi Siswa</h1>
        <p>Silakan pilih menu di samping untuk melanjutkan aktivitas Anda.</p>
    </div>

    <!-- Bootstrap JS dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>

<?php
$conn->close();
?>
