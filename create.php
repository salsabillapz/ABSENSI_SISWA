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
        if (file_put_contents($fotoFile, $fotoData)) {
            $fotoUrl = $fotoFile; // URL relative to your script
        } else {
            echo "Gagal menyimpan foto.";
            $fotoUrl = ''; // No photo
        }
    } else {
        $fotoUrl = ''; // No photo
    }

    // Insert into database
    $sql = "INSERT INTO absensi (nama_siswa, tanggal, status, foto) VALUES ('$nama_siswa', '$tanggal', '$status', '$fotoUrl')";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php'); // Redirect to dashboard after success
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="dashboard.php" button type="button" class="btn-close mb-3" aria-label="Close"></a>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h1 class="text-center mb-4">Tambah Absensi</h1>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpa">Alpa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="video" class="form-label">Absen Foto</label>
                        <div class="text-center">
                            <video id="video" width="100%" height="auto" autoplay></video>
                            <canvas id="canvas" class="d-none"></canvas>
                            <button type="button" class="btn btn-secondary mt-2" id="capture">Ambil Foto</button>
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
                alert("Kamera tidak dapat diakses. Pastikan izin diberikan.");
            });

        // Capture the photo
        captureButton.addEventListener('click', () => {
            if (video.srcObject) {
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageDataURL = canvas.toDataURL('image/png');
                fotoInput.value = imageDataURL;
            } else {
                alert("Kamera tidak tersedia. Pastikan kamera diakses dengan benar.");
            }
        });
    </script>
</body>
</html>
