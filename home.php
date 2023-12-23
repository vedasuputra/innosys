<?php

include "connect.php";
include "statistics.php";

// Display data from innovdata
$recordsPerPage = 8;
$query = "SELECT innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType 
          FROM innovdata 
          JOIN type ON innovdata.IDType = type.IDType 
          JOIN concentration ON innovdata.IDConc = concentration.IDConc 
          JOIN category ON innovdata.IDCateg = category.IDCateg 
          WHERE innovdata.Status = 'Approved'
          ORDER BY `innovdata`.`creDate` DESC
          LIMIT $recordsPerPage";
$result = mysqli_query($koneksi, $query);

include "header.php";
?>

<html>

<head>
  <title>Home | SIFORS Innovation System</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="general.css" />
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
  <div class="headline home">
    <div class="headline-content">
      <h1 class="headline-title">Welcome to Innovation System</h1>
      <p>
        Check out all the innovations made by the students and the lecturers
        of UNDIKSHA’s Information System study program here.
      </p>
      <button onclick="javascript:location.href='catalogue.html'" type="button" class="headline-button">
        View Catalogue
      </button>
    </div>
  </div>

  <div class="container">
    <div class="section-head">
      <div>
        <h1 class="section-title">Highlight</h1>
      </div>
      <div class="navbar-end">
        <div class="button-wrapper">
          <button class="swipe-button am-prev" style="margin-right: 7px">
            <i class="bx bx-chevron-left" style="font-size: 30px"></i>
          </button>
          <button class="swipe-button am-next">
            <i class="bx bx-chevron-right" style="font-size: 30px"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="owl-carousel owl-theme">
      <div class="item">
        <?php

        $counter = 0;

        while ($row = mysqli_fetch_assoc($result)) {

          $IDInnov = $row['IDInnov'];
          $nameInnov = $row['NameInnov'];
          $creDate = date("F j, Y", strtotime($row['CreDate']));
          $SubmDate = date("F j, Y", strtotime($row['SubmDate']));
          $categoryName = $row['NameCateg'];
          $images = explode(",", $row['Img']);

          if ($counter > 0 && $counter % 4 == 0) {
            echo '</div>';
            echo '<div class="item">';
          }

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

          $counter++;
        }

        ?>
      </div>
    </div>

    <div class="categories-container">
      <div>
        <h1 class="section-title">Categories</h1>
        <div class="category-container">
          <div onclick="javascript:location.href='#'">
            <i class="category-icon bx bxs-book-alt"></i>
            <div class="category-details">
              <h2>Thesis</h2>
              <div class="category-desc">
                Innovations made for students' final projects
              </div>
            </div>
          </div>
          <div onclick="javascript:location.href='#'">
            <i class="category-icon bx bxs-briefcase"></i>
            <div class="category-details">
              <h2>Internship</h2>
              <div class="category-desc">
                Innovations made for students' training program
              </div>
            </div>
          </div>
          <div onclick="javascript:location.href='#'">
            <i class="category-icon bx bxs-grid-alt"></i>
            <div class="category-details">
              <h2>Others</h2>
              <div class="category-desc">
                Independent studies, competitions, and more
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <h1 class="section-title">Type</h1>
        <div class="type-container">
          <div onclick="javascript:location.href='#'">
            <div class="type-name">Website</div>
            <i class="type-icon bx bx-globe"></i>
          </div>
          <div onclick="javascript:location.href='#'">
            <div class="type-name">Desktop App</div>
            <i class="type-icon bx bx-desktop"></i>
          </div>
          <div onclick="javascript:location.href='#'">
            <div class="type-name">Mobile App</div>
            <i class="type-icon bx bx-mobile"></i>
          </div>
          <div onclick="javascript:location.href='#'">
            <div class="type-name">Others</div>
            <i class="type-icon bx bx-dots-horizontal-rounded"></i>
          </div>
        </div>
      </div>
      <div>
        <h1 class="section-title">Concentration</h1>
        <div class="type-container">
          <div onclick="javascript:location.href='#'">
            <div class="type-name">Cybersecurity</div>
            <i class="type-icon bx bxs-lock-alt"></i>
          </div>
          <div onclick="javascript:location.href='#'">
            <div class="type-name">Management Information System</div>
            <i class="type-icon bx bxs-business"></i>
          </div>
          <div onclick="javascript:location.href='#'">
            <div class="type-name">Engineering and Business Intelligence</div>
            <i class="type-icon bx bxs-cog"></i>
          </div>
          <div onclick="javascript:location.href='#'">
            <div class="type-name">Others</div>
            <i class="type-icon bx bx-dots-horizontal-rounded"></i>
          </div>
        </div>
      </div>
    </div>

    <?php include "statistics-js.php"; ?>

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