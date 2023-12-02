<?php

include "connect.php";
// error_reporting(0);


if (isset($_POST['submit'])) {
    $NameInnov = $_POST['NameInnov'];
    $Description = $_POST['Description'];
    $SubmDate = $_POST['SubmDate'];
    $CreDate = $_POST['CreDate'];

    $ImgArray = [];
    if (is_array($_FILES['Img']['name'])) {
        $totalFiles = count($_FILES['Img']['name']);

        for ($i = 0; $i < $totalFiles; $i++) {
            $Img = $_FILES['Img']['name'][$i];
            $location = "image/" . $Img;
            move_uploaded_file($_FILES['Img']['tmp_name'][$i], $location);
            $ImgArray[] = $Img;
        }
        $ImgString = implode(",", $ImgArray);
    } else {
        $Img = $_FILES['Img']['name'];
        $location = "image/" . $Img;
        move_uploaded_file($_FILES['Img']['tmp_name'], $location);
        $ImgString = $Img;
    }
    /*else {
        // Handle the case when only one file is uploaded
        $Img = $_FILES['Img']['name'];
        $location = "image/" . $Img;
        move_uploaded_file($_FILES['Img']['tmp_name'], $location);
        $ImgArray[] = $Img;
    }
    /*$Img = $_FILES['Img']['name'];
    $location = "image/" . $Img;
    move_uploaded_file($_FILES['Img']['tmp_name'], $location); // Fix typo here */



    $Link = $_POST['Link'];
    $LinkYT = $_POST['LinkYT'];
    $IDConc = $_POST['IDConc'];
    $IDCateg = $_POST['IDCateg'];
    $IDType = $_POST['IDType'];
    $id_user_array = $_POST['IDUser'];


    $query = "INSERT INTO innovdata (NameInnov, Description, Status, SubmDate, CreDate, Link, Img, LinkYoutube, IDConc, IDCateg, IDType) VALUES
     ('$NameInnov','$Description','Pending','$SubmDate','$CreDate','$Link','$ImgString', '$LinkYT', '$IDConc', '$IDCateg', '$IDType')"; // Fix column name here

    $result = mysqli_query($koneksi, $query);

    if (mysqli_query($koneksi, $query)) {
        $IDInnov = mysqli_insert_id($koneksi);

        foreach ($id_user_array as $IDUser) {
            $query_user = "INSERT INTO userinnov (IDInnov, IDUser) VALUES ('$IDInnov', '$IDUser')";

            if (!mysqli_query($koneksi, $query_user)) {
                echo "error:" . $query_user . "<br>" . mysqli_error($koneksi);
            }
        }
        echo "<script>alert('success'); </script>";
    } else {
        echo "<script>alert('errors'); </script>";
    }

    if (!$result) {
        echo "<script>alert('errors'); </script>";
    } else {
        echo "<script>alert('success'); </script>"; // Fix typo here
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Form</title>
</head>

<body>
    <form method="POST" action="" enctype="multipart/form-data">
        <table>
            <tr>
                <div>
                    Submission Form
                </div>
            </tr>
            <tr>
                <td><label for="NameInnov"> Innovation Name </label></td>
                <td><input type="text" name="NameInnov" placeholder="Input your innovation name"></td>
            </tr>
            <tr>
                <td><label for="Description">Description </label></td>
                <td><textarea name="Description" placeholder="Add description here"></textarea></td>
            </tr>
            <tr>
                <td><label for="SubmDate">Submit Date</label></td>
                <td><input type="date" name="SubmDate"></td>
            </tr>
            <tr>
                <td><label for="CreDate">Create Date</label></td>
                <td><input type="date" name="CreDate"></td>
            </tr>
            <div style="display: none;">
                <input type="file" name="Img[]" id="fileInput" multiple onchange="updateList()">
            </div>
            <tbody>
                <tr>
                    <td><input type="button" value="Choose Image" onclick="document.getElementById('fileInput').click()">
                        <div id="fileList"></div>
                </tr>
            </tbody>
            <tr>
                <td>Link</td>
                <td><input type="link" name="Link" placeholder="Input your Link"></td>
            </tr>
            <tr>
                <td>Link Youtube</td>
                <td><input type="link" name="LinkYT" placeholder="Input your Link Youtube"></td>
            </tr>
            <tr>
                <td>Concentration: </td>
                <td><select name="IDConc">
                        <option value="1"> Cyber Security</option>
                        <option value="2"> Management Information</option>
                        <option value="3"> Engineering and Bussiness</option>
                        <option value="4"> Others</option>
                    </select></td>
            </tr>
            <tr>
                <td>Category: </td>
                <td><select name="IDCateg">
                        <option value="1"> Thesis</option>
                        <option value="2"> Internship</option>
                        <option value="3"> Others</option>
                    </select></td>
            </tr>
            <tr>
                <td>Type: </td>
                <td><select name="IDType">
                        <option value="1"> Website</option>
                        <option value="2"> Desktop</option>
                        <option value="3"> MobileApp</option>
                        <option value="4"> Others</option>
                    </select></td>
            </tr>
            <tbody id="user">
                <tr class="user">
                    <td>NIM/NIDN: </td>
                    <td><input type="text" name="IDUser[]"></td>
                    <td><button type="button" onclick="removeUser(this)">Delete</button></td>
                </tr>
            </tbody>
            </tbody>

            <td><button type="button" onclick="addUser()"> Add more </button></td>

            <tr>
                <td><input type="submit" value="submit" name="submit"></td>
            </tr>
        </table>
    </form>
    <script>
        function addUser() {
            var userContainer = document.getElementById('user');
            var newUser = document.createElement('tr');
            newUser.className = 'user';
            newUser.innerHTML = '<td>NIM/NIDN: </td><td><input type="text" name="IDUser[]"></td>';
            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.textContent = 'Delete';
            removeButton.onclick = function() {
                removeUser(this);
            }
            newUser.appendChild(removeButton);
            /*var lastUser = userContainer.lastElementChild;*/
            userContainer.appendChild(newUser);
        }

        function removeUser(button) {
            var userContainer = document.getElementById('user');
            var userDiv = button.parentNode;
            userContainer.removeChild(userDiv);
        }

        function updateList() {
            var input = document.getElementById('fileInput');
            var output = document.getElementById('fileList');
            var files = input.files;

            output.innerHTML = '';
            for (var i = 0; i < files.length; i++) {
                output.innerHTML += '<p>' + files[i].name + '</p>';
            }
        }

        /*function addImage() {
            var inputContainer = document.getElementById('imageContainer');
            var newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'Img[]';
            inputContainer.appendChild(newInput);
        }

        function removeImage() {
            var inputContainer = document.getElementById('imageContainer');
            var lastInput = inputContainer.lastElementChild;
            if (lastInput) {
                inputContainer.removeChild(lastInput);
            }
        }*/
    </script>
    <style>