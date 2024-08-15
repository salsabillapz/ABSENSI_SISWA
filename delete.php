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

// Cek jika id ada di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil URL foto dari database untuk menghapus file yang terkait
    $sql = "SELECT foto FROM absensi WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $foto = $row['foto'];
        
        // Hapus file foto jika ada
        if (!empty($foto) && file_exists($foto)) {
            unlink($foto);
        }

        // Hapus data dari database
        $sql = "DELETE FROM absensi WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            header('Location: dashboard.php'); // Redirect ke dashboard setelah sukses
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "ID tidak diberikan.";
}

$conn->close();
?>
