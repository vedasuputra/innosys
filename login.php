<?php

include "loginfix.php";
?>

<html>

<head>
  <title>Log In | SIFORS Innovation System</title>
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