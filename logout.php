<?php
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login (ganti "login.php" dengan halaman login Anda)
header("Location: home.php");
exit();
