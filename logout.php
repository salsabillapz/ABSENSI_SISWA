<?php
// Logout dan redirect ke halaman login
// Misalnya, jika Anda menggunakan sesi:
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit();
?>
