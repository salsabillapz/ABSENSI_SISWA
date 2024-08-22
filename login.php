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
    $remember_me = isset($_POST['remember_me']); // Check if the remember me checkbox was selected

    // Cek apakah username dan password sesuai
    if ($username === $valid_username && $password === $valid_password) {
        // Set sesi atau cookies jika perlu
        if ($remember_me) {
            // Set a cookie that lasts for 30 days
            setcookie('username', $username, time() + (86400 * 30), "/");
        }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center justify-content-center vh-100"
style="background: linear-gradient(135deg, #1E90FF, #00BFFF);">
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="row w-100">
            <div class="col-md-8 col-lg-6 col-xl-4 mx-auto d-flex flex-column justify-content-center">
                <?php if ($show_form): ?>
                    <div class="card border rounded p-5">
                        <div class="row no-gutters">
                            <div class="col-12 text-center mb-4">
                                <!-- Tambahkan ikon profil di sini -->
                                <i class="bi bi-person-circle" style="font-size: 4rem; color: #0dcaf0;"></i>
                                <h3 class="text-center mt-3">Welcome</h3>
                            </div>
                            <div class="col-12">
                                <!-- Tampilkan pesan error jika ada -->
                                <?php if (isset($error_message)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error_message; ?>
                                    </div>
                                <?php endif; ?>

                                <form action="" method="POST">
                                    <div class="mb-4">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Masukkan Username" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Masukkan Password" required>
                                    </div>
                                    <div class="mb-5 form-check">
                                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                                        <label class="form-check-label" for="remember_me">Remember Me</label>
                                    </div>
                                    <button type="submit" class="btn w-100 shadow text-white"
                                        style="background: linear-gradient(135deg, #1E90FF, #00BFFF); font-weight: bold;">Login</button>
                                </form>
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
