<?php
$koneksi = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (mysqli_connect_errno()){
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}
?>

<?php
$query = "SELECT COUNT(*) AS total FROM category";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);
$total_data = $row['total'];
echo "Jumlah data dalam tabel: " . $total_data;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jumlah Data</title>
</head>
<body>
    <h1>Jumlah Data</h1>
    <p>Jumlah data dalam tabel: <?php echo $total_data; ?></p>
</body>
</html>