<?php
session_start();

// Fungsi untuk menghubungkan ke database (gantilah dengan informasi database Anda)
function connectToDatabase()
{
  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "innosys";

  $conn = new mysqli($host, $username, $password, $database);

  if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
  }

  return $conn;
}

// Fungsi untuk melakukan login
function loginUser($username, $password)
{
  $conn = connectToDatabase();

  // Coba mencari di tabel user
  $query = "SELECT * FROM user WHERE IDUser= '$username' AND UserPass = '$password'";
  $result = $conn->query($query);

  if ($result->num_rows == 1) {
    // Login berhasil sebagai user
    $row = $result->fetch_assoc();

    if (isset($row['Username'])) {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      $_SESSION['role'] = 'user';
      $_SESSION['nama'] = $row['Username'];
      header("Location: user.php");
      exit();
    }
  }

  // Coba mencari di tabel admin
  $query = "SELECT * FROM admin WHERE IDAdmin = '$username' AND PasswordAdmin = '$password'";
  $result = $conn->query($query);

  if ($result->num_rows == 1) {
    // Login berhasil sebagai admin
    $_SESSION["loggedin"] = true;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'admin';
    header("Location: admin.html");
    exit();
  }

  // Login gagal
  echo "<script> alert('Wrong username or password'); </script>";
  $conn->close();
}

// Proses login jika form login dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  loginUser($username, $password);
}
?>

<html>

<head>
  <title>Submission Form | SIFORS Innovation System</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="submission.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
  <a href="dashboard.html">
    <h2>Innovation System</h2>
  </a>

  <div class="content">
    <h1>Login Page</h1>
    <h4>Access your dashboard.</h4>

    <form action="loginfix.php" method="post" enctype="multipart/form-data">
      <div class="input-container">
        <label for="username">ID (NIDN/NIM)</label>
        <i class='bx bxs-user'></i>
        <input type="text" id="username" placeholder="Insert your ID here..." name="username" maxlength="10" required value="">
      </div>
      <div class="input-container" style="margin-top: 20px;">
        <label for="UserPass">Password</label>
        <i class='bx bxs-key'></i>
        <input type="password" id="password" placeholder="Insert your password here..." name="password" required value="">
      </div>
      <input type="submit" value="Submit" class="submit" name="submit">
    </form>
  </div>

  <p>
    © Universitas Pendidikan Ganesha<br>
    Copyright 2023. All Rights Reserved
  </p>
</body>

</html>