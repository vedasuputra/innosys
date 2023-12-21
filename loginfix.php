<?php
// error_reporting(0);

session_start();

// Fungsi untuk menghubungkan ke database (gantilah dengan informasi database Anda)

// Fungsi untuk melakukan login
function loginUser($username, $password)
{
  include "connect.php";

  // Coba mencari di tabel user
  $query = "SELECT * FROM user WHERE IDUser= '$username' AND UserPass = '$password'";
  $result = $koneksi->query($query);

  if ($result->num_rows == 1) {
    // Login berhasil sebagai user
    $row = $result->fetch_assoc();

    if (isset($row['Username'])) {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      $_SESSION['role'] = 'user';
      $_SESSION['nama'] = $row['Username'];
      $_SESSION['IDUser'] = $row['IDUser'];
      header("Location: user.php");
      exit();
    }
  }

  // Coba mencari di tabel admin
  $query = "SELECT * FROM admin WHERE IDAdmin = '$username' AND PasswordAdmin = '$password'";
  $result = $koneksi->query($query);

  if ($result->num_rows == 1) {
    // Login berhasil sebagai admin
    $_SESSION["loggedin"] = true;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'admin';
    header("Location: admin.php");
    exit();
  }

  // Login gagal
  echo "<script> alert('Wrong username or password'); </script>";
  $koneksi->close();
}

// Proses login jika form login dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  loginUser($username, $password);
}
?>

