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
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            transition: all 0.3s;
        }

        .sidebar h4 {
            padding: 15px;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar .nav-link.active {
            background-color: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4>Dashboard</h4>
        <a href="#" class="nav-link active"><i class="bi bi-house"></i> Home</a>
        <a href="#" class="nav-link"><i class="bi bi-people"></i> Data Siswa</a>
        <a href="#" class="nav-link"><i class="bi bi-calendar-check"></i> Rekap Absensi</a>
        <a href="#" class="nav-link"><i class="bi bi-file-earmark-pdf"></i> Laporan PDF</a>
        <a href="#" class="nav-link"><i class="bi bi-gear"></i> Pengaturan</a>
        <a href="#" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-4 text-center">Data Absensi Siswa</h2>
                    <a href="create.php" class="btn btn-primary mb-3">Tambah Absensi</a>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Siswa</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['nama_siswa']; ?></td>
                                            <td><?php echo $row['tanggal']; ?></td>
                                            <td><?php echo $row['status']; ?></td>
                                            <td>
                                                <?php if (!empty($row['foto'])): ?>
                                                    <img src="<?php echo $row['foto']; ?>" class="foto-img" alt="Foto Absensi" width="50">
                                                <?php else: ?>
                                                    Tidak ada foto
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Anda yakin ingin menghapus data ini?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
