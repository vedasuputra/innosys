<?php
    $name = $_POST['name'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $concentration = $_POST['concentration'];
    $inolink = $_POST['inolink'];
    $youtube = $_POST['youtube'];
    $images = $_POST['images'];
    $description = $_POST['description'];
    $group = $_POST['group'];
    $id = $_POST['id'];
    $email = $_POST['email'];

    //Database Connection
    $conn = new mysqli('localhost','root','','test');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }else{
       $stmt = $conn->prepare("insert into innovationsystemdb(name, date, category, type, concentration, inolink, youtube, images, description, group, id, email)
       values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    }
?>