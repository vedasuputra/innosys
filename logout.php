<?php
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Make sure no content is outputted before this point
header("Location: home.php");
exit();
?>