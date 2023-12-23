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

$recordsPerPage = 12;

$allpage = isset($_GET['page']) ? $_GET['page'] : 1;
$alloffset = ($allpage - 1) * $recordsPerPage;

$acceptedpage = isset($_GET['page']) ? $_GET['page'] : 1;
$acceptedoffset = ($acceptedpage - 1) * $recordsPerPage;

$rejectedpage = isset($_GET['page']) ? $_GET['page'] : 1;
$rejectedoffset = ($rejectedpage - 1) * $recordsPerPage;

// Not pending submitted innovations
$allSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                  FROM innovdata 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  WHERE innovdata.Status != 'Pending'
                  ORDER BY `innovdata`.`SubmDate` DESC
                  LIMIT $alloffset, $recordsPerPage";

$allstmt = mysqli_prepare($koneksi, $allSubmit);
mysqli_stmt_execute($allstmt);
$allresult = mysqli_stmt_get_result($allstmt);

$allRecordsQuery = "SELECT COUNT(*) as total FROM innovdata WHERE innovdata.Status != 'Pending'";
$allRecordsResult = mysqli_query($koneksi, $allRecordsQuery);
$allRecords = mysqli_fetch_assoc($allRecordsResult)['total'];
$allPages = ceil($allRecords / $recordsPerPage);

// Accepted submitted innovations
$acceptedSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                  FROM innovdata 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  WHERE innovdata.Status = 'Approved'
                  ORDER BY `innovdata`.`SubmDate` DESC
                  LIMIT $acceptedoffset, $recordsPerPage";

$acceptedstmt = mysqli_prepare($koneksi, $acceptedSubmit);
mysqli_stmt_execute($acceptedstmt);
$acceptedresult = mysqli_stmt_get_result($acceptedstmt);

$acceptedRecordsQuery = "SELECT COUNT(*) as total FROM innovdata WHERE innovdata.Status = 'Approved'";
$acceptedRecordsResult = mysqli_query($koneksi, $acceptedRecordsQuery);
$acceptedRecords = mysqli_fetch_assoc($acceptedRecordsResult)['total'];
$acceptedPages = ceil($acceptedRecords / $recordsPerPage);

// Rejected submitted innovations
$rejectedSubmit = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
                  FROM innovdata 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  WHERE innovdata.Status = 'Rejected'
                  ORDER BY `innovdata`.`SubmDate` DESC
                  LIMIT $rejectedoffset, $recordsPerPage";

$rejectedstmt = mysqli_prepare($koneksi, $rejectedSubmit);
mysqli_stmt_execute($rejectedstmt);
$rejectedresult = mysqli_stmt_get_result($rejectedstmt);

$rejectedRecordsQuery = "SELECT COUNT(*) as total FROM innovdata WHERE innovdata.Status = 'Rejected'";
$rejectedRecordsResult = mysqli_query($koneksi, $rejectedRecordsQuery);
$rejectedRecords = mysqli_fetch_assoc($rejectedRecordsResult)['total'];
$rejectedPages = ceil($rejectedRecords / $recordsPerPage);
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
    <div id="innovationsAll" class="tabcontent2">
      <div class="section-head" style="margin-top: 2.5rem;">
        <div>
          <h1 class="section-title">Innovations History</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction4(event)" class="dropbtn">All</button>
            <div id="myDropdown4" class="dropdown-content">
              <a class="droplinks" onclick="openTab2(event, 'innovationsAll')" id="defaultOpenAll">All</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsAccepted')" id="defaultOpenAccepted">Accepted</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsRejected')" id="defaultOpenRejected">Rejected</a>

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
      <div class="pagination-container" style="margin-top: 25px;">
        <a href="?status=all&page=<?php echo max(1, $allpage - 1); ?>" class="pagination-link"><button class="swipe-button white"><i class="bx bx-chevron-left" style="font-size: 30px;"></i></button></a>
        <div style="text-align: center;">
          <?php
          for ($i = 1; $i <= $allPages; $i++) {
            $buttonClass = ($i == $allpage) ? 'swipe-button number' : 'swipe-button white number';
            echo '<a href="?status=all&page=' . $i . '"><button class="' . $buttonClass . '">' . $i . '</button></a>';
          }
          ?>
        </div>
        <div style="text-align: right;">
          <a href="?status=all&page=<?php echo min($allPages, $allpage + 1); ?>" class="pagination-link"><button class="swipe-button white"><i class="bx bx-chevron-right" style="font-size: 30px;"></i></button></a>
        </div>
      </div>
    </div>

    <div id="innovationsAccepted" class="tabcontent2">
      <div class="section-head" style="margin-top: 2.5rem;">
        <div>
          <h1 class="section-title">Innovations History</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction5(event)" class="dropbtn">Accepted</button>
            <div id="myDropdown5" class="dropdown-content">
              <a class="droplinks" onclick="openTab2(event, 'innovationsAll')" id="defaultOpenAll">All</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsAccepted')" id="defaultOpenAccepted">Accepted</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsRejected')" id="defaultOpenRejected">Rejected</a>

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

            echo '<div class="creators-info pointer" onclick="javascript:location.href=\'innovation.php?id=' . $IDInnov . '\'">';
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
      <div class="pagination-container" style="margin-top: 25px;">
        <a href="?status=accepted&page=<?php echo max(1, $acceptedpage - 1); ?>" class="pagination-link"><button class="swipe-button white"><i class="bx bx-chevron-left" style="font-size: 30px;"></i></button></a>
        <div style="text-align: center;">
          <?php
          for ($i = 1; $i <= $acceptedPages; $i++) {
            $buttonClass = ($i == $acceptedpage) ? 'swipe-button number' : 'swipe-button white number';
            echo '<a href="?status=accepted&page=' . $i . '"><button class="' . $buttonClass . '">' . $i . '</button></a>';
          }
          ?>
        </div>
        <div style="text-align: right;">
          <a href="?status=accepted&page=<?php echo min($acceptedPages, $acceptedpage + 1); ?>" class="pagination-link"><button class="swipe-button white"><i class="bx bx-chevron-right" style="font-size: 30px;"></i></button></a>
        </div>
      </div>
    </div>

    <div id="innovationsRejected" class="tabcontent2">
      <div class="section-head" style="margin-top: 2.5rem;">
        <div>
          <h1 class="section-title">Innovations History</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction6(event)" class="dropbtn">Rejected</button>
            <div id="myDropdown6" class="dropdown-content">
              <a class="droplinks" onclick="openTab2(event, 'innovationsAll')" id="defaultOpenAll">All</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsAccepted')" id="defaultOpenAccepted">Accepted</a>
              <a class="droplinks" onclick="openTab2(event, 'innovationsRejected')" id="defaultOpenRejected">Rejected</a>

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
      <div class="pagination-container" style="margin-top: 25px;">
        <a href="?status=rejected&page=<?php echo max(1, $rejectedpage - 1); ?>" class="pagination-link"><button class="swipe-button white"><i class="bx bx-chevron-left" style="font-size: 30px;"></i></button></a>
        <div style="text-align: center;">
          <?php
          for ($i = 1; $i <= $rejectedPages; $i++) {
            $buttonClass = ($i == $rejectedpage) ? 'swipe-button number' : 'swipe-button white number';
            echo '<a href="?status=rejected&page=' . $i . '"><button class="' . $buttonClass . '">' . $i . '</button></a>';
          }
          ?>
        </div>
        <div style="text-align: right;">
          <a href="?status=rejected&page=<?php echo min($rejectedPages, $page + 1); ?>" class="pagination-link"><button class="swipe-button white"><i class="bx bx-chevron-right" style="font-size: 30px;"></i></button></a>
        </div>
      </div>
    </div>
  </div>

  <?php include "footer.php" ?>

  <script>
    // When the user clicks on the button, toggle between hiding and showing the dropdown content
    function myFunction4(event) {
      event.stopPropagation();
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

    // When the user clicks on the button, toggle between hiding and showing the dropdown content
    function myFunction5(event) {
      event.stopPropagation();
      document.getElementById("myDropdown5").classList.toggle("show");
    }

    // When the user clicks on the button, toggle between hiding and showing the dropdown content
    function myFunction6(event) {
      event.stopPropagation();
      document.getElementById("myDropdown6").classList.toggle("show");
    }

    function openTab2(evt, tabName) {
      var j, tabcontent, droplinks;
      tabcontent = document.getElementsByClassName("tabcontent2");
      for (j = 0; j < tabcontent.length; j++) {
        tabcontent[j].style.display = "none";
      }
      droplinks = document.getElementsByClassName("droplinks");
      for (j = 0; j < droplinks.length; j++) {
        droplinks[j].classList.remove("active");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.classList.add("active");

      // Update the URL based on the selected tab
      var pageName, currentPage;
      if (tabName === "innovationsAccepted") {
        pageName = "accepted";
        currentPage = <?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>;
      } else if (tabName === "innovationsRejected") {
        pageName = "rejected";
        currentPage = <?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>;
      } else {
        pageName = "all";
        currentPage = <?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>;
      }

      history.pushState(null, null, "?status=" + pageName + "&page=" + currentPage);
    }

    // Handle dropdown clicks
    function handleDropdown(event, dropdownId) {
      event.stopPropagation();
      var dropdown = document.getElementById(dropdownId);
      dropdown.classList.toggle("show");
    }

    // Close dropdowns if the user clicks outside of them
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
    };

    document.addEventListener("DOMContentLoaded", function() {
      // Get the current status from the URL
      var urlParams = new URLSearchParams(window.location.search);
      var status = urlParams.get("status");

      // Default to 'all' if no status is specified
      if (!status) {
        status = "all";
      }

      // Click on the appropriate tab based on the status
      if (status === "accepted") {
        document.getElementById("defaultOpenAccepted").click();
      } else if (status === "rejected") {
        document.getElementById("defaultOpenRejected").click();
      } else {
        document.getElementById("defaultOpenAll").click();
      }
    });
  </script>

</body>

</html>