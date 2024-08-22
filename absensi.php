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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

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

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .main-content h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #1d3557;
            text-align: center;
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

    <div class="main-content">
        <div class="card-absensi">
            <div class="card-header">Absensi Siswa</div>
            <form>
                <!-- Input Nama -->
                <div class="form-group mt-4">
                    <label for="nama">Nama Siswa</label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan nama siswa">
                </div>

                <!-- Input Kelas -->
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select class="form-control" id="kelas">
                        <option>XII RPL 1</option>
                        <option>XII RPL 2</option>
                        <option>XII TKJ 1</option>
                        <!-- Tambahkan opsi kelas lainnya -->
                    </select>
                </div>
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
                                        <img src="<?php echo $row['foto']; ?>" class="img-fluid" alt="Foto Absensi" width="50">
                                    <?php else: ?>
                                        Tidak ada foto
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Anda yakin ingin menghapus data ini?');">
                                        <i class="bi bi-trash"></i> Hapus
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
