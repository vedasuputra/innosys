<?php
$name = $date = $category = $type = $concentration = $inolink = $youtube = $nama_file = '';
$description = $group = $id = $email = '';

// print_r($_POST);
$lokasi_upload = "assets/upload/"; // Anda dapat mengganti "uploads/" sesuai dengan folder penyimpanan yang diinginkan
if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $concentration = $_POST['concentration'];
    $inolink = $_POST['inolink'];
    $youtube = $_POST['youtube'];
    $nama_file = $_FILES['file']['name'];
    $ukuran_file = $_FILES['file']['size'];
    $nama_sementara = $_FILES['file']['tmp_name'];
    $tujuan = $lokasi_upload . $nama_file;

    $description = $_POST['description'];
    $group = $_POST['group'];
    $id = $_POST['id'];
    $email = $_POST['email'];
    }

    //Database Connection
    $conn = new mysqli('localhost','root','','innovationsystemdb');
    $query = "INSERT INTO innovationdata (IDInnov, NameInnov, Description, CreDate, SubmDate, Img, Link, Status, IDCateg, IDConc, IDType, CreatorID) VALUES ('Inno0001', '$name', '$description', '$date', '0000-00-00', '$nama_file', '$inolink', 'Pending', '$category', '$concentration', '$type', 'Cre001')";
    $upload= mysqli_query($conn, $query);

    if($upload){
        echo "<script> alert('Your innovation has been submitted succesfully'); </script>";
    } else {
        echo "<script> alert('Failed to submit your innovation'); </script>";
    }
?>