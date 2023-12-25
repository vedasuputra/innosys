<?php

include "header.php";
include "connect.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  session_unset();
  session_destroy();
  echo "<script>
          alert('You must be logged in as a user to access this page.');
          window.location.href = 'login.php';
        </script>";
  exit();
}

if ($_SESSION['role'] !== 'user') {
  echo "<script>
          alert('You must be logged in as a user to access this page.');
          window.history.back();
        </script>";
  exit();
}

$recordsPerPage = 8;

$status2 = isset($_GET['status']) ? $_GET['status'] : 'all';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $recordsPerPage;

if ($status2 === 'all') {
  $historyquery = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                    FROM innovdata 
                    JOIN type ON innovdata.IDType = type.IDType 
                    JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                    JOIN category ON innovdata.IDCateg = category.IDCateg 
                    JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                    WHERE userinnov.IDUser = ? 
                    ORDER BY `innovdata`.`SubmDate` DESC
                    LIMIT ? OFFSET ?";
  $historystmt = $koneksi->prepare($historyquery);
  $historystmt->bind_param("sii", $_SESSION['username'], $recordsPerPage, $offset);
  $historystmt->execute();
  $historyresult = $historystmt->get_result();
} 

else {
  $historyquery = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                    FROM innovdata 
                    JOIN type ON innovdata.IDType = type.IDType 
                    JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                    JOIN category ON innovdata.IDCateg = category.IDCateg 
                    JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                    WHERE userinnov.IDUser = ? AND innovdata.Status = ?
                    ORDER BY `innovdata`.`SubmDate` DESC
                    LIMIT ? OFFSET ?";
  $historystmt = $koneksi->prepare($historyquery);
  $historystmt->bind_param("ssii", $_SESSION['username'], $status2, $recordsPerPage, $offset);
  $historystmt->execute();
  $historyresult = $historystmt->get_result();
}

$totalPages = ceil($koneksi->query("SELECT COUNT(*) FROM innovdata JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov WHERE userinnov.IDUser = '{$_SESSION['username']}'" . ($status2 === 'all' ? '' : " AND status = '$status2'"))->fetch_row()[0] / $recordsPerPage);

// Newest innovation
$recordsPerPage2 = 4;
$query = "SELECT innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
          FROM innovdata 
          JOIN type ON innovdata.IDType = type.IDType 
          JOIN concentration ON innovdata.IDConc = concentration.IDConc 
          JOIN category ON innovdata.IDCateg = category.IDCateg 
          JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
          WHERE  innovdata.Status = 'Approved' AND userinnov.IDUser = ?
          ORDER BY `innovdata`.`creDate` DESC
          LIMIT $recordsPerPage2";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i',  $_SESSION['username']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
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
                  category.NameCateg, category.IDCateg,
                  COUNT(CASE WHEN innovdata.Status = 'Approved' AND userinnov.IDUser = {$_SESSION["username"]} THEN innovdata.IDCateg END) as categoryCount
                  FROM category
                  LEFT JOIN innovdata ON category.IDCateg = innovdata.IDCateg
                  LEFT JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                  WHERE innovdata.Status = 'Approved'
                  GROUP BY category.NameCateg
                  ORDER BY category.IDCateg ASC";
$categoryCountResult = mysqli_query($koneksi, $categoryCount);
$categoryCounts = array();

while ($row = mysqli_fetch_assoc($categoryCountResult)) {
  $categoryName = $row['NameCateg'];
  $categoryID = $row['IDCateg'];
  $categoryCountTotal = $row['categoryCount'];
  $categoryCounts[$categoryName] = $categoryCountTotal;
}

// Type count
$typeCount = "SELECT 
              type.NameType, type.IDType,
              COUNT(CASE WHEN innovdata.Status = 'Approved' AND userinnov.IDUser = {$_SESSION["username"]} THEN innovdata.IDType END) as typeCount
              FROM type
              LEFT JOIN innovdata ON type.IDType = innovdata.IDType
              LEFT JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
              WHERE innovdata.Status = 'Approved'
              GROUP BY type.NameType
              ORDER BY type.IDType ASC";
$typeCountResult = mysqli_query($koneksi, $typeCount);
$typeCounts = array();

while ($row = mysqli_fetch_assoc($typeCountResult)) {
  $typeName = $row['NameType'];
  $typeID = $row['IDType'];
  $typeCountTotal = $row['typeCount'];
  $typeCounts[$typeName] = $typeCountTotal;
}

// Concentration count
$concCount = "SELECT 
              concentration.NameConc, concentration.IDConc,
              COUNT(CASE WHEN innovdata.Status = 'Approved' AND userinnov.IDUser = {$_SESSION["username"]} THEN innovdata.IDConc END) as concCount
              FROM concentration
              LEFT JOIN innovdata ON concentration.IDConc = innovdata.IDConc
              LEFT JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
              WHERE innovdata.Status = 'Approved'
              GROUP BY concentration.NameConc
              ORDER BY concentration.IDConc ASC";
$concCountResult = mysqli_query($koneksi, $concCount);
$concCounts = array();

while ($row = mysqli_fetch_assoc($concCountResult)) {
  $concName = $row['NameConc'];
  $concID = $row['IDConc'];
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
      <button onclick="window.open('submission.php');" type="button" class="headline-button">Submit Innovation</button>
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
        <div class="creators-info pointer" onclick="window.open('catalogue.php');">
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
          if ($categoryName == 'Thesis') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?category=1\');">';
          } elseif ($categoryName == 'Internship') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?category=2\');">';
          } elseif ($categoryName == 'Others') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?category=3\');">';
          }
          echo '<div>';
          echo '<div class="user-stat-number">' . $count . '</div>';
          echo '<div class="user-stat-detail">' . $categoryName . '</div>';
          echo '</div>';
          echo '<div>';
          if ($categoryName == 'Thesis') {
            echo '<i class=\'bx bxs-book-alt user-stat-icon\'></i>';
          } elseif ($categoryName == 'Internship') {
            echo '<i class=\'bx bxs-briefcase user-stat-icon\'></i>';
          } elseif ($categoryName == 'Others') {
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
          if ($typeName == 'Website') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?type=1\');">';
          } elseif ($typeName == 'Desktop App') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?type=2\');">';
          } elseif ($typeName == 'Mobile App') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?type=3\');">';
          } elseif ($typeName == 'Others') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?type=4\');">';
          }
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
          } elseif ($typeName == 'Others') {
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
          if ($concName == 'Cybersecurity') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?concentration=1\');">';
          } elseif ($concName == 'Management Information System') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?concentration=2\');">';
          } elseif ($concName == 'Engineering and Business Intelligence') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?concentration=3\');">';
          } elseif ($concName == 'Others') {
            echo '<div class="creators-info pointer" onclick="window.open(\'catalogue.php?concentration=4\');">';
          }
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
          } elseif ($concName == 'Others') {
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
        echo '<button onclick="window.open(\'catalogue.php?user=' . $_SESSION['username'] . '\');" class="general-button">View All</button>';
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

        echo '<div class="items" onclick="window.open(\'innovation.php?id=' . $IDInnov . '\');">';
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

    <div class="section-head" style="margin-top: 2.5rem;">
      <div>
        <h1 class="section-title">Innovations History</h1>
      </div>
      <div class="navbar-end">
        <div class="dropdown">
          <button onclick="myFunction4()" class="dropbtn"><?php echo ucfirst($status2) ?></button>
          <div id="myDropdown4" class="dropdown-content">
            <a class="droplinks" href="user.php?status=all">All</a>
            <a class="droplinks" href="user.php?status=approved">Approved</a>
            <a class="droplinks" href="user.php?status=pending">Pending</a>
            <a class="droplinks" href="user.php?status=rejected">Rejected</a>
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
        echo "<a href='user.php?status=$status2&page=$prev_page'><button class='swipe-button white'><i class='bx bx-chevron-left' style='font-size: 30px;'></i></button></a>";
        echo '<div style="text-align: center;">';

        for ($i = 1; $i <= $totalPages; $i++) { $buttonClass=($i==$page) ? 'swipe-button number' : 'swipe-button white number' ; 
          echo "<a href='user.php?status=$status2&page=$i'><button class='$buttonClass'>$i</button></a>" ; 
        } 
        
        echo '</div>'; 
        echo '<div style="text-align: right;">' ; $next_page=$page + 1; 
        echo "<a href='user.php?status=$status2&page=$next_page' class='pagination-link'><button class='swipe-button white'><i class='bx bx-chevron-right' style='font-size: 30px;'></i></button></a>" ; 
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
            function openTab(evt, tabName) {
              var j, tabcontent, droplinks;
              tabcontent = document.getElementsByClassName("tabcontent");
              for (j = 0; j < tabcontent.length; j++) {
                tabcontent[j].style.display = "none";
              }
              droplinks = document.getElementsByClassName("tablinks");
              for (j = 0; j < droplinks.length; j++) {
                droplinks[j].className = droplinks[i].className.replace(
                  " active",
                  ""
                );
              }
              document.getElementById(tabName).style.display = "block";
              evt.currentTarget.className += " active";
            }

            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();
          </script>

          <script>
            /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
            function myFunction() {
              document.getElementById("myDropdown").classList.toggle("show");
            }

            /* When the user clicks on the button, 
            toggle between hiding and showing the dropdown content */
            function myFunction2() {
              document.getElementById("myDropdown2").classList.toggle("show");
            }

            /* When the user clicks on the button, 
            toggle between hiding and showing the dropdown content */
            function myFunction3() {
              document.getElementById("myDropdown3").classList.toggle("show");
            }

            // When the user clicks on the button, toggle between hiding and showing the dropdown content
            function myFunction4() {
              document.getElementById("myDropdown4").classList.toggle("show");
            }

            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
              if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                  var openDropdown = dropdowns[i];
                  if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                  }
                }
              }
            }
          </script>



</body>

</html>