<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sekolah"; // Ganti dengan nama database Anda

$connection = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

// Ambil filter dari input pengguna
$filterTanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
$filterStatus = isset($_GET['status']) ? $_GET['status'] : '';

// Query untuk mendapatkan data absensi berdasarkan filter
$query = "SELECT * FROM absensi WHERE 1=1";

if ($filterTanggal != '') {
    $query .= " AND tanggal = '$filterTanggal'";
}

if ($filterStatus != '' && $filterStatus != 'Semua Status') {
    $query .= " AND status = '$filterStatus'";
}

$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Daftar Siswa</a></li>
            <li><a href="absensi.php"><i class="fas fa-clipboard-list"></i> Absensi</a></li>
            <li><a href="rekap.php"><i class="fas fa-file-alt"></i> Rekap Absensi</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>


    <!-- Content -->
    <div class="main-content">
        <h2>Rekap Absensi Siswa</h2>
        <form method="GET" action="">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="filterTanggal" class="form-label">Filter Tanggal</label>
                    <input type="date" class="form-control" id="filterTanggal" name="tanggal">
                </div>
                <div class="col-md-4">
                    <label for="filterStatus" class="form-label">Filter Status</label>
                    <select class="form-select" id="filterStatus" name="status">
                        <option selected>Semua Status</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Alpa">Alpa</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
        </form>

        <!-- Tabel Rekap Absensi -->
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['nama_siswa'] . "</td>";
                            echo "<td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <button class="btn btn-primary mt-3" onclick="print()">Cetak PDF</button>
    </div>

    <script>
        function print() {
            window.print();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Tutup koneksi
$connection->close();
?>
