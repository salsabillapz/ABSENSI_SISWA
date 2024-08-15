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

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_siswa = $_POST['nama_siswa'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    $foto = $_POST['foto']; // Data URL foto

    // Simpan foto sebagai file
    if (!empty($foto)) {
        $foto = str_replace('data:image/png;base64,', '', $foto);
        $foto = str_replace(' ', '+', $foto);
        $fotoData = base64_decode($foto);
        $fotoFile = 'uploads/' . uniqid() . '.png'; // Generate unique file name
        file_put_contents($fotoFile, $fotoData);
        $fotoUrl = $fotoFile; // URL relative to your script
    } else {
        $fotoUrl = ''; // No photo
    }

    // Update data di database
    $sql = "UPDATE absensi SET nama_siswa='$nama_siswa', tanggal='$tanggal', status='$status', foto='$fotoUrl' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php'); // Redirect ke dashboard setelah sukses
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Ambil data untuk ditampilkan di formulir
$sql = "SELECT * FROM absensi WHERE id=$id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="dashboard.php" class="btn-close mb-3" aria-label="Close"></a>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h1 class="text-center mb-4">Edit Absensi</h1>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="<?php echo htmlspecialchars($data['nama_siswa']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Hadir" <?php if ($data['status'] == 'Hadir') echo 'selected'; ?>>Hadir</option>
                            <option value="Tidak Hadir" <?php if ($data['status'] == 'Tidak Hadir') echo 'selected'; ?>>Tidak Hadir</option>
                            <option value="Izin" <?php if ($data['status'] == 'Izin') echo 'selected'; ?>>Izin</option>
                            <option value="Sakit" <?php if ($data['status'] == 'Sakit') echo 'selected'; ?>>Sakit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="video" class="form-label">Absen Foto</label>
                        <div class="text-center">
                            <video id="video" width="100%" height="auto" autoplay></video>
                            <canvas id="canvas" class="d-none"></canvas>
                            <button type="button" class="btn btn-secondary mt-2" id="capture">Ambil Foto</button>
                            <?php if (!empty($data['foto'])): ?>
                                <div class="mt-3">
                                    <img src="<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto" class="img-fluid">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <input type="hidden" name="foto" id="foto">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('capture');
        const fotoInput = document.getElementById('foto');

        // Access the user's webcam
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing the camera: " + err);
            });

        // Capture the photo
        captureButton.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageDataURL = canvas.toDataURL('image/png');
            fotoInput.value = imageDataURL;
        });
    </script>
</body>
</html>
