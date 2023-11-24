<?php
$host = "localhost";
$IDUser = "root";
$UserPass = "";

$conn = new mysqli('localhost','root','','innovationsystemdb');

if(mysqli_connect_error()){
    die('Failed to Login('. mysqli_connect_errno() .')'. mysqli_connect_error());
}
else{
    $sql = "INSERT INTO user (IDUser, UserPass)
    VALUES ('$IDUser','$UserPass')";
    if($conn->query($sql)){
        echo "Login Sucessfully";
    }
    else{
        echo "Login Failed". $sql ."<br>". $conn->error;
    }
    $conn->close();
}


//if(isset($_POST["submit"])){
//    $IDUser = $_POST['IDUser'];
//    $UserPass = $_POST['UserPass'];
//}

//$query = "INSERT INTO user (IDUser, UserPass) VALUES ($IDUser, $UserPass)";
//$upload= mysqli_query($conn, $query);
?>