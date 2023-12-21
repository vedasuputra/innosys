<?php

include "header.php";
include "connect.php";
include "statistics.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role'] !== 'admin') {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit();
}

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
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
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
    <h1 class="section-title">Waiting for Approval (2)</h1>
  </div>

  <div class="innovation-creators" style="margin-top: 0">
    <div class="creators-info pointer" onclick="javascript:location.href='#'">
      <div>
        <div class="creator-name">
          <span class="status pending">Pending</span>Rudaya~Connect The Art
        </div>
        <div class="creator-role">Submitted on September 12, 2023</div>
      </div>
      <div>
        <i class="bx bx-chevron-right more-icon right"></i>
      </div>
    </div>
    <div class="creators-info pointer" onclick="javascript:location.href='#'">
      <div>
        <div class="creator-name">
          <span class="status pending">Pending</span>Rudaya~Connect The Art
        </div>
        <div class="creator-role">Submitted on September 12, 2023</div>
      </div>
      <div>
        <i class="bx bx-chevron-right more-icon right"></i>
      </div>
    </div>
  </div>

  <div class="section-head" style="margin-top: 2.5rem">
    <div>
      <h1 class="section-title">Innovations History</h1>
    </div>
    <div class="navbar-end">
      <button onclick="javascript:location.href='history.html';" class="general-button">
        View All
      </button>
    </div>
  </div>

  <div class="innovation-creators" style="margin-top: 0">
    <div class="creators-info pointer" onclick="javascript:location.href='#'">
      <div>
        <div class="creator-name">
          <span class="status accepted">Accepted</span>Sistem Informasi
          Manajemen Sampah Terpadu Milik Kita
        </div>
        <div class="creator-role">Reviewed on September 06, 2023</div>
      </div>
      <div>
        <i class="bx bx-chevron-right more-icon right"></i>
      </div>
    </div>
    <div class="creators-info pointer" onclick="javascript:location.href='#'">
      <div>
        <div class="creator-name">
          <span class="status rejected">Rejected</span>Sistem Inovasi Prodi
          Sistem Informasi UNDIKSHA
        </div>
        <div class="creator-role">Reviewed on September 01, 2023</div>
      </div>
      <div>
        <i class="bx bx-chevron-right more-icon right"></i>
      </div>
    </div>
  </div>
  <div class="innovation-creators">
    <div class="creators-info pointer" onclick="javascript:location.href='#'">
      <div>
        <div class="creator-name">
          <span class="status accepted">Accepted</span>Sistem Prestasi Prodi
          Sistem Informasi UNDIKSHA
        </div>
        <div class="creator-role">Reviewed on September 01, 2023</div>
      </div>
      <div>
        <i class="bx bx-chevron-right more-icon right"></i>
      </div>
    </div>
    <div class="creators-info pointer" onclick="javascript:location.href='#'">
      <div>
        <div class="creator-name">
          <span class="status accepted">Accepted</span>Sistem Perwalian
          Prodi Sistem Informasi UNDIKSHA
        </div>
        <div class="creator-role">Reviewed on September 01, 2023</div>
      </div>
      <div>
        <i class="bx bx-chevron-right more-icon right"></i>
      </div>
    </div>
  </div>

  <div id="innovationsRejected" class="tabcontent2">
    <div class="section-head" style="margin-top: 2.5rem">
      <div>
        <h1 class="section-title">Innovations History</h1>
      </div>
      <div class="navbar-end">
        <div class="dropdown">
          <button onclick="myFunction6()" class="dropbtn">Rejected</button>
          <div id="myDropdown6" class="dropdown-content">
            <a class="droplinks" onclick="openTab2(event, 'innovationsAll')">All</a>
            <a class="droplinks" onclick="openTab2(event, 'innovationsAccepted')">Accepted</a>
            <a class="droplinks" onclick="openTab2(event, 'innovationsRejected')">Rejected</a>
          </div>
        </div>
      </div>
    </div>
    <div class="innovation-creators" style="margin-top: 0">
      <div class="creators-info pointer" onclick="javascript:location.href='#'">
        <div>
          <div class="creator-name">
            <span class="status rejected">Rejected</span>Elektropedia
          </div>
          <div class="creator-role bigger-margin">
            Submitted on September 04, 2023
          </div>
        </div>
        <div>
          <i class="bx bx-chevron-right more-icon right"></i>
        </div>
      </div>
      <div class="creators-info pointer" onclick="javascript:location.href='#'">
        <div>
          <div class="creator-name">
            <span class="status rejected">Rejected</span>Sistem Perwalian
            Prodi Sistem Informasi UNDIKSHA
          </div>
          <div class="creator-role bigger-margin">
            Submitted on September 01, 2023
          </div>
        </div>
        <div>
          <i class="bx bx-chevron-right more-icon right"></i>
        </div>
      </div>
    </div>
  </div>
  </div>

  <?php include "footer.php"?>

  <script>
    /* When the user clicks on the button, 
  toggle between hiding and showing the dropdown content */
    function profileFunction() {
      document.getElementById("profileDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
      if (!event.target.matches(".profilebtn")) {
        var dropdowns = document.getElementsByClassName("user-dropdown");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains("show")) {
            openDropdown.classList.remove("show");
          }
        }
      }
    };
  </script>

  <script>
    $(function () {
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
      $(".am-next").click(function () {
        owl.trigger("next.owl.carousel");
      });
      // Go to the previous item
      $(".am-prev").click(function () {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owl.trigger("prev.owl.carousel", [300]);
      });
    });
  </script>
</body>

</html>