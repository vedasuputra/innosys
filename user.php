<?php

include "header.php";
include "connect.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role'] !== 'user') {
  header("Location: login.php");
  exit();
}


// $get1 = mysqli_query($conn, "SELECT * FROM innovdata INNER JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov WHERE userinnov.IDUser = ?");

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
      <button onclick="javascript:location.href='submission.html'" type="button" class="headline-button">Submit Innovation</button>
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
            <div class="user-stat-number">6</div>
            <div class="user-stat-detail">Total</div>
          </div>
          <div>
            <i class='bx bxs-box user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">1</div>
            <div class="user-stat-detail">Thesis</div>
          </div>
          <div>
            <i class='bx bxs-book-alt user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">1</div>
            <div class="user-stat-detail">Internship</div>
          </div>
          <div>
            <i class='bx bxs-briefcase user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">4</div>
            <div class="user-stat-detail">Others</div>
          </div>
          <div>
            <i class='bx bxs-grid-alt user-stat-icon'></i>
          </div>
        </div>
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
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">1</div>
            <div class="user-stat-detail">Website</div>
          </div>
          <div>
            <i class='bx bx-globe user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">2</div>
            <div class="user-stat-detail">Desktop App</div>
          </div>
          <div>
            <i class='bx bx-desktop user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">3</div>
            <div class="user-stat-detail">Mobile App</div>
          </div>
          <div>
            <i class='bx bx-mobile user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">0</div>
            <div class="user-stat-detail">Others</div>
          </div>
          <div>
            <i class='bx bx-dots-horizontal-rounded user-stat-icon'></i>
          </div>
        </div>
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
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">2</div>
            <div class="user-stat-detail">Cybersecurity</div>
          </div>
          <div>
            <i class='bx bxs-lock-alt user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">1</div>
            <div class="user-stat-detail" style="text-align: right;">Management Information System</div>
          </div>
          <div>
            <i class='bx bxs-business user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">2</div>
            <div class="user-stat-detail">Engineering and Business Intelligence</div>
          </div>
          <div>
            <i class='bx bxs-cog user-stat-icon'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="user-stat-number">1</div>
            <div class="user-stat-detail">Others</div>
          </div>
          <div>
            <i class='bx bx-dots-horizontal-rounded user-stat-icon'></i>
          </div>
        </div>
      </div>
    </div>

    <div class="section-head" style="margin-top: 2.5rem;">
      <div>
        <h1 class="section-title">Newest Innovations</h1>
      </div>
      <div class="navbar-end">
        <button onclick="javascript:location.href='catalogue.html';" class="general-button">View All</button>
      </div>
    </div>
    <div class="owl-carousel owl-theme">
      <div class="item">
        <div class="items" onclick="javascript:location.href='#'">
          <img src="photos\card2.jpg">
          <div class="card-content">
            <div>
              <div class="card-title">Rudaya~Connect The Art
              </div>
              <div class="card-category"><a href="#">Internship</a></div>
            </div>
            <div class="card-details">
              <div>
                <i class='bx bx-calendar-alt' style="margin-right: 7px; font-size: 14px; line-height: 1.1;"></i>
              </div>
              <div>September 9, 2023</div>
            </div>
          </div>
        </div>
        <div class="items" onclick="javascript:location.href='#'">
          <img src="photos\card4.jpg">
          <div class="card-content">
            <div>
              <div class="card-title">Sistem Inovasi Prodi Sistem Informasi UNDIKSHA</div>
              <div class="card-category"><a href="#">Thesis</a></div>
            </div>
            <div class="card-details">
              <div>
                <i class='bx bx-calendar-alt' style="margin-right: 7px; font-size: 14px; line-height: 1.1;"></i>
              </div>
              <div>September 4, 2023</div>
            </div>
          </div>
        </div>
        <div class="items" onclick="javascript:location.href='#'">
          <img src="photos\card9.jpg">
          <div class="card-content">
            <div>
              <div class="card-title">AI Image Detector Information System</div>
              <div class="card-category"><a href="#">Others</a></div>
            </div>
            <div class="card-details">
              <div>
                <i class='bx bx-calendar-alt' style="margin-right: 7px; font-size: 14px; line-height: 1.1;"></i>
              </div>
              <div>August 30, 2023</div>
            </div>
          </div>
        </div>
        <div class="items" onclick="javascript:location.href='#'">
          <img src="photos\card10.jpg">
          <div class="card-content">
            <div>
              <div class="card-title">Website Heatmap Analyzer Information System</div>
              <div class="card-category"><a href="#">Internship</a></div>
            </div>
            <div class="card-details">
              <div>
                <i class='bx bx-calendar-alt' style="margin-right: 7px; font-size: 14px; line-height: 1.1;"></i>
              </div>
              <div>August 29, 2023</div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status pending">Pending</span>Rudaya~Connect The Art</div>
            <div class="creator-role bigger-margin">Submitted on September 12, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status accepted">Accepted</span>Sistem Informasi Manajemen Sampah Terpadu Milik Kita</div>
            <div class="creator-role bigger-margin">Submitted on September 06, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
      </div>
      <div class="innovation-creators">
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status rejected">Rejected</span>Elektropedia</div>
            <div class="creator-role bigger-margin">Submitted on September 04, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status accepted">Accepted</span>Sistem Inovasi Prodi Sistem Informasi UNDIKSHA</div>
            <div class="creator-role bigger-margin">Submitted on September 01, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
      </div>
      <div class="innovation-creators">
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status pending">Pending</span>Sistem Prestasi Prodi Sistem Informasi UNDIKSHA</div>
            <div class="creator-role bigger-margin">Submitted on September 01, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status rejected">Rejected</span>Sistem Perwalian Prodi Sistem Informasi UNDIKSHA</div>
            <div class="creator-role bigger-margin">Submitted on September 01, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
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
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status accepted">Accepted</span>Sistem Informasi Manajemen Sampah Terpadu Milik Kita</div>
            <div class="creator-role bigger-margin">Submitted on September 06, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status accepted">Accepted</span>Sistem Inovasi Prodi Sistem Informasi UNDIKSHA</div>
            <div class="creator-role bigger-margin">Submitted on September 01, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
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
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status pending">Pending</span>Rudaya~Connect The Art</div>
            <div class="creator-role bigger-margin">Submitted on September 12, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status pending">Pending</span>Sistem Prestasi Prodi Sistem Informasi UNDIKSHA</div>
            <div class="creator-role bigger-margin">Submitted on September 01, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
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
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status rejected">Rejected</span>Elektropedia</div>
            <div class="creator-role bigger-margin">Submitted on September 04, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
        <div class="creators-info pointer" onclick="javascript:location.href='#'">
          <div>
            <div class="creator-name"><span class="status rejected">Rejected</span>Sistem Perwalian Prodi Sistem Informasi UNDIKSHA</div>
            <div class="creator-role bigger-margin">Submitted on September 01, 2023</div>
          </div>
          <div>
            <i class='bx bx-chevron-right more-icon right'></i>
          </div>
        </div>
      </div>
    </div>

  </div>

  <footer>
    <div>
      <h3>Innovation System</h3>
      © Universitas Pendidikan Ganesha<br>
      Copyright 2023. All Rights Reserved
    </div>
    <div>
      <h4>Pages</h4>
      <a href="#">Dashboard</a>
      <a href="#">Catalogue</a>
    </div>
    <div>
      <h4>Others</h4>
      <a href="#">Help</a>
      <a href="#">Submit</a>
    </div>
  </footer>

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