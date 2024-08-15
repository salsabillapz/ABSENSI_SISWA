<?php
// Proses login jika form telah disubmit
$show_form = true;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Username dan password yang diizinkan (hardcoded)
    $valid_username = 'admin';
    $valid_password = 'admin*123';

    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username dan password sesuai
    if ($username === $valid_username && $password === $valid_password) {
        // Set sesi atau cookies jika perlu
        // Redirect ke halaman berikutnya
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center justify-content-center vh-100"
    style="background: linear-gradient(135deg, #1E90FF, #00BFFF);">
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="row w-100">
            <div class="col-md-12 col-lg-10 col-xl-8 mx-auto d-flex flex-column justify-content-center">
                <?php if ($show_form): ?>
                    <div class="card border rounded">
                        <div class="row no-gutters">
                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                <img src="hallow.png" class="img-fluid rounded-start" alt="..."
                                    style="width: 100%; max-height: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-5 d-flex align-items-center">
                                <div class="card-body">
                                    <h3 class="text-center mb-4">Login</h3>

                                    <!-- Tampilkan pesan error jika ada -->
                                    <?php if (isset($error_message)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>

                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Masukkan Username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Masukkan Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 shadow">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Pesan login berhasil di tengah halaman dan full desktop -->
                    <div class="d-flex align-items-center justify-content-center vh-100">
                        <div class="alert alert-success w-100 text-center rounded">
                            <?php echo $success_message; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>