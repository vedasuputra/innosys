<?php

include "header.php";
include "connect.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  session_unset();
  session_destroy();
  echo "<script>
          alert('Error: You must be logged in as an admin to access this page.');
          window.location.href = 'login.php';
        </script>";
  exit();
}

if ($_SESSION['role'] !== 'admin') {
  echo "<script>
          alert('Error: You must be logged in as an admin to access this page.');
          window.history.back();
        </script>";
  exit();
}

$recordsPerPage = 16;

$status2 = isset($_GET['status']) ? $_GET['status'] : 'all';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $recordsPerPage;

if ($status2 === 'all') {
  $historyquery = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                    FROM innovdata 
                    JOIN type ON innovdata.IDType = type.IDType 
                    JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                    JOIN category ON innovdata.IDCateg = category.IDCateg 
                    WHERE innovdata.Status != 'Pending'
                    ORDER BY `innovdata`.`SubmDate` DESC
                    LIMIT ? OFFSET ?";
  $historystmt = $koneksi->prepare($historyquery);
  $historystmt->bind_param("ii", $recordsPerPage, $offset);
  $historystmt->execute();
  $historyresult = $historystmt->get_result();
} 

else {
  $historyquery = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                    FROM innovdata 
                    JOIN type ON innovdata.IDType = type.IDType 
                    JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                    JOIN category ON innovdata.IDCateg = category.IDCateg 
                    WHERE innovdata.Status = ?
                    ORDER BY `innovdata`.`SubmDate` DESC
                    LIMIT ? OFFSET ?";
  $historystmt = $koneksi->prepare($historyquery);
  $historystmt->bind_param("sii", $status2, $recordsPerPage, $offset);
  $historystmt->execute();
  $historyresult = $historystmt->get_result();
}

$totalPages = ceil($koneksi->query("SELECT COUNT(*) FROM innovdata WHERE 1" . ($status2 === 'all' ? '' : " AND status = '$status2'"))->fetch_row()[0] / $recordsPerPage);
?>

<html>

<head>
  <title>Innovation History | SIFORS Innovation System</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="admin.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="userdropdown.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</head>

<body>
  <div class="headline admin">
    <div class="headline-content">
      <h1 class="headline-title">History of Innovations</h1>
      <p>You can see all innovations that have been validated here, be it accepted or rejected. </p>
    </div>
  </div>

  <div class="container">
    <div class="section-head" style="margin-top: 2.5rem;">
      <div>
        <h1 class="section-title">Innovations History</h1>
      </div>
      <div class="navbar-end">
        <div class="dropdown">
          <button onclick="myFunction4()" class="dropbtn"><?php echo ucfirst($status2) ?></button>
          <div id="myDropdown4" class="dropdown-content">
            <a class="droplinks" href="history.php?status=all">All</a>
            <a class="droplinks" href="history.php?status=approved">Approved</a>
            <a class="droplinks" href="history.php?status=rejected">Rejected</a>
          </div>
        </div>
      </div>
    </div>
    <div class="innovation-creators" style="margin-top: 0;">
    <?php
        if ($historyresult->num_rows > 0) {
        $counter = 0;

        while ($row = mysqli_fetch_assoc($historyresult)) {

          $IDInnov = $row['IDInnov'];
          $nameInnov = $row['NameInnov'];
          $status = $row['Status'];
          $creDate = date("F j, Y", strtotime($row['CreDate']));
          $SubmDate = date("F j, Y", strtotime($row['SubmDate']));

          if ($counter > 0 && $counter % 2 == 0) {
            echo '</div>';
            echo '<div class="innovation-creators">';
          }

          if ($status == 'Approved') {
            echo '<div class="creators-info pointer" onclick="window.open(\'innovation.php?id=' . $IDInnov . '\');">';
          } else {
            echo '<div class="creators-info pointer" onclick="window.open(\'detail.php?id=' . $IDInnov . '\');">';
          }

          echo '<div>';
          echo '<div class="creator-name"><span class="status ' . $status . '">' . $status . '</span>' . $nameInnov . '</div>';
          echo '<div class="creator-role bigger-margin">Submitted on ' . $SubmDate . '</div>';
          echo '</div>';
          echo '<div>';
          echo '<i class=\'bx bx-chevron-right more-icon right\'></i>';
          echo '</div>';
          echo '</div>';

          $counter++;
        }
      
        echo '</div>';
        echo '<div class="pagination-container" style="margin-top: 25px;">';

        $prev_page = $page - 1;
        echo "<a href='history.php?status=$status2&page=$prev_page'><button class='swipe-button white'><i class='bx bx-chevron-left' style='font-size: 30px;'></i></button></a>";
        echo '<div style="text-align: center;">';

        for ($i = 1; $i <= $totalPages; $i++) { $buttonClass=($i==$page) ? 'swipe-button number' : 'swipe-button white number' ; 
          echo "<a href='history.php?status=$status2&page=$i'><button class='$buttonClass'>$i</button></a>" ; 
        } 
        
        echo '</div>'; 
        echo '<div style="text-align: right;">' ; $next_page=$page + 1; 
        echo "<a href='history.php?status=$status2&page=$next_page' class='pagination-link'><button class='swipe-button white'><i class='bx bx-chevron-right' style='font-size: 30px;'></i></button></a>" ; 
        echo '</div>'; 
        echo '</div>'; 

        }
        else {
          echo '<div class="creators-info info" style="width: 10fr!important">';
          echo '<div>No results found.</div>';
          echo '<div><i class=\'bx bxs-info-circle right\' style="font-size: 22px; line-height: 1;"></i></div>';
          echo '</div>';
          echo '</div>';
        }
      ?>
  </div>

  <?php include "footer.php" ?>

  <script>
    // When the user clicks on the button, toggle between hiding and showing the dropdown content
    function myFunction4() {
      document.getElementById("myDropdown4").classList.toggle("show");
    }
  </script>

</body>

</html>