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
    echo "Username atau password salah";
    $conn->close();
}

// Proses login jika form login dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    loginUser($username, $password);
}
?>

<!-- Form HTML untuk login -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>

</html>