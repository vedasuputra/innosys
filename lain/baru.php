<?php

include "connect.php";
// error_reporting(0);


if (isset($_POST['submit'])) {
    $NameInnov = $_POST['NameInnov'];
    $Description = $_POST['Description'];
    $SubmDate = $_POST['SubmDate'];
    $CreDate = $_POST['CreDate'];
    $Img = $_FILES['Img']['name'];
    $location = "image/" . $Img;
    move_uploaded_file($_FILES['Img']['tmp_name'], $location); // Fix typo here
    $Link = $_POST['Link'];
    $LinkYT = $_POST['LinkYT'];
    $IDConc = $_POST['IDConc'];
    $IDCateg = $_POST['IDCateg'];
    $IDType = $_POST['IDType'];
    $id_user_array = $_POST['IDUser'];
    $query = "INSERT INTO innovdata (NameInnov, Description, Status, SubmDate, CreDate, Link, Img, LinkYoutube, IDConc, IDCateg, IDType) VALUES
     ('$NameInnov','$Description','Pending','$SubmDate','$CreDate','$Link','$Img', '$LinkYT', '$IDConc', '$IDCateg', '$IDType')"; // Fix column name here
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

    /*if (!$result) {
        echo "<script>alert('errors'); </script>";
    } else {
        echo "<script>alert('success'); </script>"; // Fix typo here
    }*/
}
mysqli_close($koneksi);

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
                <td>Nama Innovasi</td>
                <td><input type="text" name="NameInnov" placeholder="Input your innovation name"></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="Description" placeholder="Add description here"></td>
            </tr>
            <tr>
                <td>Submit Date</td>
                <td><input type="date" name="SubmDate"></td>
            </tr>
            <tr>
                <td>Create Date</td>
                <td><input type="date" name="CreDate"></td>
            </tr>
            <tr>
                <td>Image</td>
                <td><input type="file" name="Img" accept="image/*"></td>
            </tr>
            <tr>
                <td>Link</td>
                <td><input type="link" name="Link" placeholder="Input your Link"></td>
            </tr>
            <tr>
                <td>Link Youtube</td>
                <td><input type="link" name="LinkYT" placeholder="Input your Link Youtube"></td>
            </tr>
            <tr>
                Concentration:
                <select name="IDConc">
                    <option value="1"> Cyber Security</option>
                    <option value="2"> Management Information</option>
                    <option value="3"> Engineering and Bussiness</option>
                    <option value="4"> Others</option>
                </select><br>
            </tr>
            <tr>
                Category:
                <select name="IDCateg">
                    <option value="1"> Thesis</option>
                    <option value="2"> Internship</option>
                    <option value="3"> Others</option>
                </select><br>
            </tr>
            <tr>
                Type:
                <select name="IDType">
                    <option value="1"> Website</option>
                    <option value="2"> Desktop</option>
                    <option value="3"> MobileApp</option>
                    <option value="4"> Others</option>
                </select><br>
            </tr>
            <div id="user">
                <div class="user">
                    NIM/NIDN: <input type="text" name="IDUser[]"><br>
                </div>
            </div>
            <button type="button" onclick="addUser()"> Add more </button><br>
            <tr>
                <td><input type="submit" value="submit" name="submit" onclick="this.disabled=true; this.form.submit();"></td>
            </tr>
        </table>
    </form>
    <script>
        function addUser() {
            var userContainer = document.getElementById('user');
            var newUser = document.createElement('div');
            newUser.className = 'user';
            newUser.innerHTML = 'NIM/NIDN:<input type="text" name="IDUser[]"><br>';
            userContainer.appendChild(newUser);
        }
    </script>
</body>

</html>