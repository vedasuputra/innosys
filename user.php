<?php

include "header.php";
include "connect.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role'] !== 'user') {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit();
}

// Newest innovation
$recordsPerPage = 4;
$query = "SELECT innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
          FROM innovdata 
          JOIN type ON innovdata.IDType = type.IDType 
          JOIN concentration ON innovdata.IDConc = concentration.IDConc 
          JOIN category ON innovdata.IDCateg = category.IDCateg 
          JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
          WHERE  innovdata.Status = 'Approved' AND userinnov.IDUser = ?
          ORDER BY `innovdata`.`creDate` DESC
          LIMIT $recordsPerPage";
          
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i',  $_SESSION['username']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// All submitted innovations
$allSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
              FROM innovdata 
              JOIN type ON innovdata.IDType = type.IDType 
              JOIN concentration ON innovdata.IDConc = concentration.IDConc 
              JOIN category ON innovdata.IDCateg = category.IDCateg 
              JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
              WHERE userinnov.IDUser = ?
              ORDER BY `innovdata`.`creDate` DESC";

$allstmt = mysqli_prepare($koneksi, $allSubmit);
mysqli_stmt_bind_param($allstmt, 'i',  $_SESSION['username']);
mysqli_stmt_execute($allstmt);
$allresult = mysqli_stmt_get_result($allstmt);

// Accepted submitted innovations
$acceptedSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                  FROM innovdata 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                  WHERE userinnov.IDUser = ? AND innovdata.Status = 'Approved'
                  ORDER BY `innovdata`.`creDate` DESC";

$acceptedstmt = mysqli_prepare($koneksi, $acceptedSubmit);
mysqli_stmt_bind_param($acceptedstmt, 'i',  $_SESSION['username']);
mysqli_stmt_execute($acceptedstmt);
$acceptedresult = mysqli_stmt_get_result($acceptedstmt);

// Pending submitted innovations
$pendingSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                  FROM innovdata 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                  WHERE userinnov.IDUser = ? AND innovdata.Status = 'Pending'
                  ORDER BY `innovdata`.`creDate` DESC";

$pendingstmt = mysqli_prepare($koneksi, $pendingSubmit);
mysqli_stmt_bind_param($pendingstmt, 'i',  $_SESSION['username']);
mysqli_stmt_execute($pendingstmt);
$pendingresult = mysqli_stmt_get_result($pendingstmt);

// Rejected submitted innovations
$rejectedSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                  FROM innovdata 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                  WHERE userinnov.IDUser = ? AND innovdata.Status = 'Rejected'
                  ORDER BY `innovdata`.`creDate` DESC";

$rejectedstmt = mysqli_prepare($koneksi, $rejectedSubmit);
mysqli_stmt_bind_param($rejectedstmt, 'i',  $_SESSION['username']);
mysqli_stmt_execute($rejectedstmt);
$rejectedresult = mysqli_stmt_get_result($rejectedstmt);
?>

<?php
// All count
$allCount = "SELECT COUNT(*) AS total 
          FROM innovdata 
          JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
          WHERE innovdata.Status = 'Approved' AND userinnov.IDUser = {$_SESSION["username"]}";
$allCountResult = mysqli_query($koneksi, $allCount);
$allCountRow = mysqli_fetch_assoc($allCountResult);
$allCountTotal = $allCountRow['total'];

// Category count
$categoryCount = "SELECT 
                  category.NameCateg,
                  COUNT(CASE WHEN innovdata.Status = 'Approved' AND userinnov.IDUser = {$_SESSION["username"]} THEN innovdata.IDCateg END) as categoryCount
                  FROM category
                  LEFT JOIN innovdata ON category.IDCateg = innovdata.IDCateg
                  LEFT JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                  GROUP BY category.NameCateg
                  ORDER BY category.IDCateg ASC";
$categoryCountResult = mysqli_query($koneksi, $categoryCount);
$categoryCounts = array();

while ($row = mysqli_fetch_assoc($categoryCountResult)) {
  $categoryName = $row['NameCateg'];
  $categoryCountTotal = $row['categoryCount'];
  $categoryCounts[$categoryName] = $categoryCountTotal;
}

// Type count
$typeCount = "SELECT 
              type.NameType,
              COUNT(CASE WHEN innovdata.Status = 'Approved' AND userinnov.IDUser = {$_SESSION["username"]} THEN innovdata.IDType END) as typeCount
              FROM type
              LEFT JOIN innovdata ON type.IDType = innovdata.IDType
              LEFT JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
              GROUP BY type.NameType
              ORDER BY type.IDType ASC";
$typeCountResult = mysqli_query($koneksi, $typeCount);
$typeCounts = array();

while ($row = mysqli_fetch_assoc($typeCountResult)) {
  $typeName = $row['NameType'];
  $typeCountTotal = $row['typeCount'];
  $typeCounts[$typeName] = $typeCountTotal;
}

// Concentration count
$concCount = "SELECT 
              concentration.NameConc,
              COUNT(CASE WHEN innovdata.Status = 'Approved' AND userinnov.IDUser = {$_SESSION["username"]} THEN innovdata.IDType END) as concCount
              FROM concentration
              LEFT JOIN innovdata ON concentration.IDConc = innovdata.IDConc
              LEFT JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
              GROUP BY concentration.NameConc
              ORDER BY concentration.IDConc ASC";
$concCountResult = mysqli_query($koneksi, $concCount);
$concCounts = array();

while ($row = mysqli_fetch_assoc($concCountResult)) {
  $concName = $row['NameConc'];
  $concCountTotal = $row['concCount'];
  $concCounts[$concName] = $concCountTotal;
}
?>

<html>

<head>
  <title>User Dashboard | SIFORS Innovation System</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="user.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="userdropdown.js"></script>
</head>

<body>
  <div class="headline user">
    <div class="headline-content">
      <h1 class="headline-title" style="overflow: hidden; -webkit-box-orient: vertical; -webkit-line-clamp: 2; display: -webkit-box;">Welcome, <?php echo $_SESSION["nama"]; ?></h1>
      <p>This is your dashboard, where you can view the approved, pending, and rejected innovations that you have submitted.</p>
      <button onclick="javascript:location.href='submission.php'" type="button" class="headline-button">Submit Innovation</button>
    </div>
  </div>

  <div class="container">
    <div id="statisticsCategory" class="tabcontent">
      <div class="section-head">
        <div>
          <h1 class="section-title">Number of Innovations</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">By category</button>
            <div id="myDropdown" class="dropdown-content">
              <a class="droplinks" onclick="openTab(event, 'statisticsCategory')" id="defaultOpen">By
                category</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By
                concentration</a>
            </div>
          </div>
        </div>
      </div>
      <div class="innovation-creators" style="margin-top: 0;">
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number"><?php echo $allCountTotal; ?></div>
            <div class="user-stat-detail">Total</div>
          </div>
          <div>
            <i class='bx bxs-box user-stat-icon'></i>
          </div>
        </div>
        <?php
        foreach ($categoryCounts as $categoryName => $count) {
          echo '<div class="creators-info pointer" onclick="javascript:location.href=\'#\'">';
          echo '<div>';
          echo '<div class="user-stat-number">' . $count . '</div>';
          echo '<div class="user-stat-detail">' . $categoryName . '</div>';
          echo '</div>';
          echo '<div>';
          if ($categoryName == 'Thesis') {
            echo '<i class=\'bx bxs-book-alt user-stat-icon\'></i>';
          } elseif ($categoryName == 'Internship') {
            echo '<i class=\'bx bxs-briefcase user-stat-icon\'></i>';
          } elseif ($categoryName == 'Other Categories') {
            echo '<i class=\'bx bxs-grid-alt user-stat-icon\'></i>';
          }
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>

    <div id="statisticsType" class="tabcontent">
      <div class="section-head">
        <div>
          <h1 class="section-title">Number of Innovations</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction2()" class="dropbtn">By type</button>
            <div id="myDropdown2" class="dropdown-content">
              <a class="droplinks" onclick="openTab(event, 'statisticsCategory')">By category</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By
                concentration</a>
            </div>
          </div>
        </div>
      </div>
      <div class="innovation-creators" style="margin-top: 0;">
        <?php
        foreach ($typeCounts as $typeName => $count) {
          echo '<div class="creators-info pointer" onclick="javascript:location.href=\'#\'">';
          echo '<div>';
          echo '<div class="user-stat-number">' . $count . '</div>';
          echo '<div class="user-stat-detail">' . $typeName . '</div>';
          echo '</div>';
          echo '<div>';
          if ($typeName == 'Website') {
            echo '<i class=\'bx bx-globe user-stat-icon\'></i>';
          } elseif ($typeName == 'Desktop App') {
            echo '<i class=\'bx bx-desktop user-stat-icon\'></i>';
          } elseif ($typeName == 'Mobile App') {
            echo '<i class=\'bx bx-mobile user-stat-icon\'></i>';
          } elseif ($typeName == 'Other Types') {
            echo '<i class=\'bx bx-dots-horizontal-rounded user-stat-icon\'></i>';
          }
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>

    <div id="statisticsConcentration" class="tabcontent">
      <div class="section-head">
        <div>
          <h1 class="section-title">Number of Innovations</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction3()" class="dropbtn">By concentration</button>
            <div id="myDropdown3" class="dropdown-content">
              <a class="droplinks" onclick="openTab(event, 'statisticsCategory')">By category</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By
                concentration</a>
            </div>
          </div>
        </div>
      </div>
      <div class="innovation-creators" style="margin-top: 0;">
        <?php
        foreach ($concCounts as $concName => $count) {
          echo '<div class="creators-info pointer" onclick="javascript:location.href=\'#\'">';
          echo '<div>';
          echo '<div class="user-stat-number">' . $count . '</div>';
          echo '<div class="user-stat-detail">' . $concName . '</div>';
          echo '</div>';
          echo '<div>';
          if ($concName == 'Cybersecurity') {
            echo '<i class=\'bx bxs-lock-alt user-stat-icon\'></i>';
          } elseif ($concName == 'Management Information System') {
            echo '<i class=\'bx bxs-business user-stat-icon\'></i>';
          } elseif ($concName == 'Engineering and Business Intelligence') {
            echo '<i class=\'bx bx-mobile user-stat-icon\'></i>';
          } elseif ($concName == 'Other Concentrations') {
            echo '<i class=\'bx bxs-cog user-stat-icon\'></i>';
          }
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>

    <?php
      if (mysqli_num_rows($result) > 0) {
        echo '<div class="section-head" style="margin-top: 2.5rem;">';
        echo '<div>';
        echo '<h1 class="section-title">Newest Innovations</h1>';
        echo '</div>';
        if ($allCountTotal > 4) {
          echo '<div class="navbar-end">';
          echo '<button onclick="javascript:location.href=\'catalogue.html\';" class="general-button">View All</button>';
          echo '</div>';
        }
        echo '</div>';
        echo '<div class="owl-carousel owl-theme">';
        echo '<div class="item">';
        while ($row = mysqli_fetch_assoc($result)) {

          $IDInnov = $row['IDInnov'];
          $nameInnov = $row['NameInnov'];
          $nametype = $row['NameType'];
          $nameConst = $row['NameConc'];
          $creDate = date("F j, Y", strtotime($row['CreDate']));
          $SubmDate = date("F j, Y", strtotime($row['SubmDate']));
          $categoryName = $row['NameCateg'];
          $images = explode(",", $row['Img']);

          echo '<div class="items" onclick="javascript:location.href=\'innovation.php?id=' . $IDInnov . '\'">';
          if (!empty($images[0])) {
            echo '<div><img src="image/' . $images[0] . '" alt="' . $nameInnov . '" ></div>';
          }
          echo '<div class="card-content">';
          echo '<div style="justify-content: normal;">';
          echo '<div class="card-title">' . $nameInnov . '</div>';
          echo '<div class="card-category">' . $categoryName . '</div>';
          echo '</div>';
          echo '<div class="card-details">';
          echo '<div>';
          echo '<i class="bx bx-calendar-alt" style="margin-right: 7px; font-size: 14px; line-height: 1.1;"></i>';
          echo '</div>';
          echo '<div>';
          echo '<div>' . $creDate . '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        echo '</div>';
        echo '</div>';
      }
    ?>
    
    <div id="innovationsAll" class="tabcontent2">
      <div class="section-head" style="margin-top: 2.5rem;">
        <div>
          <h1 class="section-title">Innovations History</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction4()" class="dropbtn">All</button>
            <div id="myDropdown4" class="dropdown-content">
              <a class="droplinks" onclick="openTab2(event, 'innovationsAll')" id="defaultOpen2">All</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsAccepted')">Accepted</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsPending')">Pending</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsRejected')">Rejected</a>
            </div>
          </div>
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
              echo '<div class="creators-info pointer" onclick="javascript:location.href=\'innovation.php?id='.$IDInnov.'\'">';
            }
            else {
              echo '<div class="creators-info pointer" onclick="javascript:location.href=\'#\'">';
            }
            
            echo '<div>';
            echo '<div class="creator-name"><span class="status '.$status.'">'.$status.'</span>' . $nameInnov . '</div>';
            echo '<div class="creator-role bigger-margin">Submitted on '.$SubmDate.'</div>';
            echo '</div>';
            echo '<div>';
            echo '<i class=\'bx bx-chevron-right more-icon right\'></i>';
            echo '</div>';
            echo '</div>';

            $counter++;
          }
        }
        else {
          // No results found
          echo '<div class="creators-info">';
          echo '<div>No results found.</div>';
          echo '<div><i class=\'bx bx-x right\' style="font-size: 22px; line-height: 1;"></i></div>';
          echo '</div>';
        }
        ?>
        
      </div>
    </div>

    <div id="innovationsAccepted" class="tabcontent2">
      <div class="section-head" style="margin-top: 2.5rem;">
        <div>
          <h1 class="section-title">Innovations History</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction5()" class="dropbtn">Accepted</button>
            <div id="myDropdown5" class="dropdown-content">
              <a class="droplinks" onclick="openTab2(event, 'innovationsAll')">All</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsAccepted')">Accepted</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsPending')">Pending</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsRejected')">Rejected</a>
            </div>
          </div>
        </div>
      </div>
      <div class="innovation-creators" style="margin-top: 0;">
        <?php
          $counter = 0;
          if (mysqli_num_rows($acceptedresult) > 0) {
            while ($row = mysqli_fetch_assoc($acceptedresult)) {

              $IDInnov = $row['IDInnov'];
              $nameInnov = $row['NameInnov'];
              $status = $row['Status'];
              $creDate = date("F j, Y", strtotime($row['CreDate']));
              $SubmDate = date("F j, Y", strtotime($row['SubmDate']));

              if ($counter > 0 && $counter % 2 == 0) {
                echo '</div>';
                echo '<div class="innovation-creators">';
              }

              echo '<div class="creators-info pointer" onclick="javascript:location.href=\'innovation.php?id='.$IDInnov.'\'">';
              echo '<div>';
              echo '<div class="creator-name"><span class="status '.$status.'">'.$status.'</span>' . $nameInnov . '</div>';
              echo '<div class="creator-role bigger-margin">Submitted on '.$SubmDate.'</div>';
              echo '</div>';
              echo '<div>';
              echo '<i class=\'bx bx-chevron-right more-icon right\'></i>';
              echo '</div>';
              echo '</div>';

              $counter++;
            }
          }
          else {
            // No results found
            echo '<div class="creators-info">';
            echo '<div>No results found.</div>';
            echo '<div><i class=\'bx bx-x right\' style="font-size: 22px; line-height: 1;"></i></div>';
            echo '</div>';
          }
        ?>
      </div>
    </div>

    <div id="innovationsPending" class="tabcontent2">
      <div class="section-head" style="margin-top: 2.5rem;">
        <div>
          <h1 class="section-title">Innovations History</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction6()" class="dropbtn">Pending</button>
            <div id="myDropdown6" class="dropdown-content">
              <a class="droplinks" onclick="openTab2(event, 'innovationsAll')">All</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsAccepted')">Accepted</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsPending')">Pending</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsRejected')">Rejected</a>
            </div>
          </div>
        </div>
      </div>
      <div class="innovation-creators" style="margin-top: 0;">
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

              echo '<div class="creators-info pointer" onclick="javascript:location.href=\'#\'">';
              echo '<div>';
              echo '<div class="creator-name"><span class="status '.$status.'">'.$status.'</span>' . $nameInnov . '</div>';
              echo '<div class="creator-role bigger-margin">Submitted on '.$SubmDate.'</div>';
              echo '</div>';
              echo '<div>';
              echo '<i class=\'bx bx-chevron-right more-icon right\'></i>';
              echo '</div>';
              echo '</div>';

              $counter++;
            }
          }
          else {
            // No results found
            echo '<div class="creators-info">';
            echo '<div>No results found.</div>';
            echo '<div><i class=\'bx bx-x right\' style="font-size: 22px; line-height: 1;"></i></div>';
            echo '</div>';
          }
        ?>
      </div>
    </div>

    <div id="innovationsRejected" class="tabcontent2">
      <div class="section-head" style="margin-top: 2.5rem;">
        <div>
          <h1 class="section-title">Innovations History</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction7()" class="dropbtn">Rejected</button>
            <div id="myDropdown7" class="dropdown-content">
              <a class="droplinks" onclick="openTab2(event, 'innovationsAll')">All</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsAccepted')">Accepted</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsPending')">Pending</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsRejected')">Rejected</a>
            </div>
          </div>
        </div>
      </div>
      <div class="innovation-creators" style="margin-top: 0;">
      <?php
          $counter = 0;
          if (mysqli_num_rows($rejectedresult) > 0) {
            while ($row = mysqli_fetch_assoc($rejectedresult)) {

              $IDInnov = $row['IDInnov'];
              $nameInnov = $row['NameInnov'];
              $status = $row['Status'];
              $creDate = date("F j, Y", strtotime($row['CreDate']));
              $SubmDate = date("F j, Y", strtotime($row['SubmDate']));

              if ($counter > 0 && $counter % 2 == 0) {
                echo '</div>';
                echo '<div class="innovation-creators">';
              }

              echo '<div class="creators-info pointer" onclick="javascript:location.href=\'#\'">';
              echo '<div>';
              echo '<div class="creator-name"><span class="status '.$status.'">'.$status.'</span>' . $nameInnov . '</div>';
              echo '<div class="creator-role bigger-margin">Submitted on '.$SubmDate.'</div>';
              echo '</div>';
              echo '<div>';
              echo '<i class=\'bx bx-chevron-right more-icon right\'></i>';
              echo '</div>';
              echo '</div>';

              $counter++;
            }
          }
          else {
            // No results found
            echo '<div class="creators-info">';
            echo '<div>No results found.</div>';
            echo '<div><i class=\'bx bx-x right\' style="font-size: 22px; line-height: 1;"></i></div>';
            echo '</div>';
          }
        ?>
      </div>
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

      var owl = $('.owl-carousel');
      owl.owlCarousel();
      // Go to the next item
      $('.am-next').click(function() {
        owl.trigger('next.owl.carousel');
      })
      // Go to the previous item
      $('.am-prev').click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owl.trigger('prev.owl.carousel', [300]);
      })

    });
  </script>

  <script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
      document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>

  <script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction2() {
      document.getElementById("myDropdown2").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>

  <script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction3() {
      document.getElementById("myDropdown3").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>

  <script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction4() {
      document.getElementById("myDropdown4").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>

  <script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction5() {
      document.getElementById("myDropdown5").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>

  <script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction6() {
      document.getElementById("myDropdown6").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>

  <script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction7() {
      document.getElementById("myDropdown7").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>

  <script>
    function openTab(evt, tabName) {
      var j, tabcontent, droplinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (j = 0; j < tabcontent.length; j++) {
        tabcontent[j].style.display = "none";
      }
      droplinks = document.getElementsByClassName("tablinks");
      for (j = 0; j < droplinks.length; j++) {
        droplinks[j].className = droplinks[i].className.replace(" active", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
  </script>

  <script>
    function openTab2(evt, tabName) {
      var j, tabcontent2, droplinks;
      tabcontent2 = document.getElementsByClassName("tabcontent2");
      for (j = 0; j < tabcontent2.length; j++) {
        tabcontent2[j].style.display = "none";
      }
      droplinks = document.getElementsByClassName("tablinks");
      for (j = 0; j < droplinks.length; j++) {
        droplinks[j].className = droplinks[i].className.replace(" active", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen2").click();
  </script>



</body>

</html>