<?php

include "header.php";
include "connect.php";
include "statistics.php";

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

// Pending submitted innovations
$pendingSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                  FROM innovdata 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  WHERE innovdata.Status = 'Pending'
                  ORDER BY `innovdata`.`SubmDate` DESC";

$pendingstmt = mysqli_prepare($koneksi, $pendingSubmit);
mysqli_stmt_execute($pendingstmt);
$pendingresult = mysqli_stmt_get_result($pendingstmt);

// Not pending submitted innovations
$recordsPerPage = 8;
$allSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                  FROM innovdata 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  WHERE innovdata.Status != 'Pending'
                  ORDER BY `innovdata`.`SubmDate` DESC
                  LIMIT $recordsPerPage";

$allstmt = mysqli_prepare($koneksi, $allSubmit);
mysqli_stmt_execute($allstmt);
$allresult = mysqli_stmt_get_result($allstmt);

?>

<html>

<head>
  <title>Admin Dashboard | SIFORS Innovation System</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="general.css" />
  <link rel="stylesheet" href="admin.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="userdropdown.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</head>

<body>
  <div class="headline admin">
    <div class="headline-content">
      <h1 class="headline-title">Welcome, Admin</h1>
      <p>
        This is your dashboard, where you can see submissions that are waiting
        for approval, the status of recent submissions, and more.
      </p>
    </div>
  </div>

  <div class="container">
    <?php include "statistics-js.php"; ?>

    <div class="section-head" style="margin-top: 2.5rem">
      <h1 class="section-title">Waiting for Approval (<?php echo $pendingCountTotal; ?>)</h1>
    </div>

    <div class="innovation-creators" style="margin-top: 0">
      <?php
      $counter = 0;
      if (mysqli_num_rows($pendingresult) > 0) {
        while ($row = mysqli_fetch_assoc($pendingresult)) {

          $IDInnov = $row['IDInnov'];
          $nameInnov = $row['NameInnov'];
          $status = $row['Status'];
          $creDate = date("F j, Y", strtotime($row['CreDate']));
          $SubmDate = date("F j, Y", strtotime($row['SubmDate']));

          if ($counter > 0 && $counter % 2 == 0) {
            echo '</div>';
            echo '<div class="innovation-creators">';
          }

          echo '<div class="creators-info pointer" onclick="javascript:location.href=\'detail.php?id=' . $IDInnov . '\'">';
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
      } else {
        // No results found
        echo '<div class="creators-info info">';
        echo '<div>No results found.</div>';
        echo '<div><i class=\'bx bxs-info-circle right\' style="font-size: 22px; line-height: 1;"></i></div>';
        echo '</div>';
      }
      ?>
    </div>

    <div class="section-head" style="margin-top: 2.5rem">
      <div>
        <h1 class="section-title">Innovations History</h1>
      </div>
      <div class="navbar-end">
        <button onclick="javascript:location.href='history.php';" class="general-button">
          View All
        </button>
      </div>
    </div>

    <div class="innovation-creators" style="margin-top: 0;">
      <?php
      $counter = 0;
      if (mysqli_num_rows($allresult) > 0) {
        while ($row = mysqli_fetch_assoc($allresult)) {

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
            echo '<div class="creators-info pointer" onclick="javascript:location.href=\'innovation.php?id=' . $IDInnov . '\'">';
          } else {
            echo '<div class="creators-info pointer" onclick="javascript:location.href=\'detail.php?id=' . $IDInnov . '\'">';
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
      } else {
        // No results found
        echo '<div class="creators-info info">';
        echo '<div>No results found.</div>';
        echo '<div><i class=\'bx bxs-info-circle right\' style="font-size: 22px; line-height: 1;"></i></div>';
        echo '</div>';
      }
      ?>
    </div>
  </div>

  <?php include "footer.php" ?>

  <script>
    $(function() {
      // Owl Carousel
      var owl = $(".owl-carousel");
      owl.owlCarousel({
        items: 1,
        margin: 20,
        loop: false,
        nav: false,
        dots: false,
        pagination: false,
        mouseDrag: false,
        touchDrag: false,
        pullDrag: false,
        freeDrag: false,
      });

      var owl = $(".owl-carousel");
      owl.owlCarousel();
      // Go to the next item
      $(".am-next").click(function() {
        owl.trigger("next.owl.carousel");
      });
      // Go to the previous item
      $(".am-prev").click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owl.trigger("prev.owl.carousel", [300]);
      });
    });
  </script>
</body>

</html>