<?php
$folder = 'uploads';

// Periksa jika folder sudah ada
if (!file_exists($folder)) {
    // Buat folder jika belum ada
    if (mkdir($folder, 0777, true)) {
        echo "Folder 'uploads' berhasil dibuat.";
    } else {
        echo "Gagal membuat folder 'uploads'.";
    }
} else {
    echo "Folder 'uploads' sudah ada.";
}
?>
