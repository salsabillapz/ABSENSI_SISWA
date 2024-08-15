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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <style>
        .bg-light-blue {
            background-color: #ADD8E6; /* Light blue color */
        }
        .foto-img {
            max-width: 150px; /* Adjust size as needed */
            height: auto;
        }
        .full-height {
            height: 100vh; /* Full viewport height */
        }
        .header-padding {
            padding: 0 15px; /* Padding for header to align with content */
        }
        .center-container {
            margin-left: auto;
            margin-right: auto;
            max-width: 1200px; /* Maximum width for container */
        }
    </style>
</head>
<body class="bg-light">
    <div class="bg-light-blue text-dark py-3 header-padding"> <!-- Persegi panjang full-width di bagian atas -->
        <div class="container">
            <nav class="nav">
                <a class="nav-link active" aria-current="page" href="#">Active</a>
                <a class="nav-link" href="#">Link</a>
                <a class="nav-link" href="#">Link</a>
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </nav>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Main Content -->
            <div class="col-md-12 py-4">
                <div class="center-container">
                    <h2 class="mb-4 text-center">Data Absensi Siswa</h2>
                    <a href="create.php" class="btn btn-primary ">Tambah Absensi</a><br>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
