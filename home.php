<?php

include "connect.php";
include "header.php";
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

// All count
$allCount = "SELECT COUNT(*) AS total FROM innovdata WHERE innovdata.Status = 'Approved'";
$allCountResult = mysqli_query($koneksi, $allCount);
$allCountRow = mysqli_fetch_assoc($allCountResult);
$allCountTotal = $allCountRow['total'];

// Category count
$categoryCount = "SELECT category.NameCateg, COUNT(*) as categoryCount 
                  FROM innovdata 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  WHERE innovdata.Status = 'Approved'
                  GROUP BY category.NameCateg
                  ORDER BY `category`.`IDCateg` ASC";
$categoryCountResult = mysqli_query($koneksi, $categoryCount);
$categoryCounts = array();

while ($row = mysqli_fetch_assoc($categoryCountResult)) {
  $categoryName = $row['NameCateg'];
  $categoryCountTotal = $row['categoryCount'];
  $categoryCounts[$categoryName] = $categoryCountTotal;
}

// Type count
$typeCount = "SELECT type.NameType, COUNT(*) as typeCount 
              FROM innovdata 
              JOIN type ON innovdata.IDType = type.IDType 
              WHERE innovdata.Status = 'Approved'
              GROUP BY type.NameType
              ORDER BY `type`.`IDType` ASC";
$typeCountResult = mysqli_query($koneksi, $typeCount);
$typeCounts = array();

while ($row = mysqli_fetch_assoc($typeCountResult)) {
  $typeName = $row['NameType'];
  $typeCountTotal = $row['typeCount'];
  $typeCounts[$typeName] = $typeCountTotal;
}

// Concentration count
$concentrationCount = "SELECT concentration.NameConc, COUNT(*) as concentrationCount 
                       FROM innovdata 
                       JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                       WHERE innovdata.Status = 'Approved'
                       GROUP BY concentration.NameConc
                       ORDER BY `concentration`.`IDConc` ASC";
$concentrationCountResult = mysqli_query($koneksi, $concentrationCount);
$concentrationCounts = array();

while ($row = mysqli_fetch_assoc($concentrationCountResult)) {
  $concentrationName = $row['NameConc'];
  $concentrationCountTotal = $row['concentrationCount'];
  $concentrationCounts[$concentrationName] = $concentrationCountTotal;
}

?>

<html>

<head>
  <title>Home | SIFORS Innovation System</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="general.css" />
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
          $nametype = $row['NameType'];
          $nameConst = $row['NameConc'];
          $creDate = date("F j, Y", strtotime($row['CreDate']));
          $SubmDate = date("F j, Y", strtotime($row['SubmDate']));
          $categoryName = $row['NameCateg'];
          $images = explode(",", $row['Img']);

          if ($counter > 0 && $counter % 4 == 0) {
            echo '</div>';
            echo '<div class="item">';
          }

          echo '<div class="items" onclick="javascript:location.href=\'innovation.php?id='. $IDInnov .'\'">';
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

          // Increment the counter
          $counter++;

          // Check if the counter is a multiple of 4
        
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

    <div id="statisticsCategory" class="tabcontent">
      <div class="section-head" style="margin-top: 2.5rem">
        <div>
          <h1 class="section-title">Statistics</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">
              By category
            </button>
            <div id="myDropdown" class="dropdown-content">
              <a class="droplinks" onclick="openTab(event, 'statisticsCategory')" id="defaultOpen">By category</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By concentration</a>
            </div>
          </div>
        </div>
      </div>

      <div class="statistics-container">
        <div class="statistics-left">
          <div class="statistics-text" onclick="javascript:location.href='#'">
            <h1>
              <?php echo $allCountTotal; ?>
            </h1>
            <span>Total Innovations</span>
          </div>
          <?php
          foreach ($categoryCounts as $categoryName => $count) {
            echo '<div class="statistics-text" onclick="javascript:location.href=\'#\'">';
            echo '<h1>' . $count . '</h1>';
            echo '<span>' . $categoryName . ' Innovations</span>';
            echo '</div>';
          }
          ?>
        </div>
        <div class="statistics-right">
          <canvas id="categoryChart"></canvas>
        </div>
      </div>
    </div>

    <div id="statisticsType" class="tabcontent">
      <div class="section-head" style="margin-top: 2.5rem">
        <div>
          <h1 class="section-title">Statistics</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction2()" class="dropbtn">By type</button>
            <div id="myDropdown2" class="dropdown-content">
              <a class="droplinks" onclick="openTab(event, 'statisticsCategory')">By category</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By concentration</a>
            </div>
          </div>
        </div>
      </div>
      <div class="statistics-container">
        <div class="statistics-left">
          <?php
          foreach ($typeCounts as $typeName => $count) {
            echo '<div class="statistics-text" onclick="javascript:location.href=\'innovation.php?id=\'">';
            echo '<h1>' . $count . '</h1>';
            echo '<span>' . $typeName . ' Innovations</span>';
            echo '</div>';
          }
          ?>
        </div>
        <div class="statistics-right">
          <canvas id="typeChart"></canvas>
        </div>
      </div>
    </div>

    <div id="statisticsConcentration" class="tabcontent">
      <div class="section-head" style="margin-top: 2.5rem">
        <div>
          <h1 class="section-title">Statistics</h1>
        </div>
        <div class="navbar-end">
          <div class="dropdown">
            <button onclick="myFunction3()" class="dropbtn">
              By concentration
            </button>
            <div id="myDropdown3" class="dropdown-content">
              <a class="droplinks" onclick="openTab(event, 'statisticsCategory')">By category</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
              <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By concentration</a>
            </div>
          </div>
        </div>
      </div>
      <div class="statistics-container">
        <div class="statistics-left">
          <?php
          foreach ($concentrationCounts as $concentrationName => $count) {
            echo '<div class="statistics-text" onclick="javascript:location.href=\'#\'">';
            echo '<h1>' . $count . '</h1>';
            echo '<span>' . $concentrationName . ' Innovations</span>';
            echo '</div>';
          }
          ?>
        </div>
        <div class="statistics-right">
          <canvas id="concentrationChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div>
      <h3>Innovation System</h3>
      © Universitas Pendidikan Ganesha<br />
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

  <script type="text/javascript">
    const count_thesis = <?php echo json_encode($count_thesis); ?>;
    const count_internship = <?php echo json_encode($count_internship); ?>;
    const count_othercategory = <?php echo json_encode($count_othercategory); ?>;
    const categoryyear = <?php echo json_encode($categoryyear); ?>;

    Chart.defaults.font.family = "Inter";
    Chart.defaults.font.size = 15;
    Chart.defaults.color = "#041f35";
    Chart.defaults.font.weight = 500;
    Chart.defaults.plugins.tooltip.cornerRadius = 4;
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.caretSize = 0;
    Chart.defaults.plugins.tooltip.usePointStyle = true;
    Chart.defaults.plugins.tooltip.labelPointStyle = "circle";
    Chart.defaults.plugins.tooltip.backgroundColor = "#041f35";
    Chart.defaults.plugins.tooltip.mode = "index";
    Chart.defaults.plugins.tooltip.boxPadding = 2;
    Chart.defaults.plugins.tooltip.boxHeight = 11;
    Chart.defaults.plugins.tooltip.bodySpacing = 3;
    Chart.defaults.plugins.tooltip.multiKeyBackground = "rgb(0,0,0,0)";
    Chart.defaults.interaction.intersect = false;
    Chart.defaults.interaction.mode = "x";

    const categoryChartData = {
      labels: categoryyear,
      datasets: [
        {
          // [0]
          label: "Other Categories",
          backgroundColor: "#0c67ac",
          data: count_othercategory
        },
        {
          // [1]
          label: "Internship",
          backgroundColor: "#2d9cf1",
          data: count_internship
        },
        {
          // [2]
          label: "Thesis",
          backgroundColor: "#75bef6",
          data: count_thesis
        },
      ],
    }

    const categoryChartConfig = {
      type: "bar",
      data: categoryChartData,

      options: {
        animation: {
          duration: 0,
        },

        scales: {
          x: {
            stacked: true,
          },

          y: {
            stacked: true,
          },

          yAxes: [
            {
              gridLines: {
                display: true,
                color: "#e8eff6",
              },
              stacked: true,
            },
          ],

          xAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
              gridLines: {
                display: true,
                color: "#e8eff6",
              },
              stacked: true,
            },
          ],
        },

        maintainAspectRatio: false,

        plugins: {
          legend: {
            display: false,
          },

          tooltip: {
            itemSort: function (a, b) {
              return b.datasetIndex - a.datasetIndex;
            },
            callbacks: {
              footer: function (items) {
                return "Total: " + items.reduce((a, b) => a + b.parsed.y, 0);
              },
            },
          },
        },
      },
    };

    const categoryChart = new Chart(
      document.getElementById('categoryChart').getContext("2d"),
      categoryChartConfig
    );
  </script>

  <script type="text/javascript">
    const count_website = <?php echo json_encode($count_website); ?>;
    const count_desktop = <?php echo json_encode($count_desktop); ?>;
    const count_mobile = <?php echo json_encode($count_mobile); ?>;
    const count_othertype = <?php echo json_encode($count_othertype); ?>;
    const typeyear = <?php echo json_encode($typeyear); ?>;

    Chart.defaults.font.family = "Inter";
    Chart.defaults.font.size = 15;
    Chart.defaults.color = "#041f35";
    Chart.defaults.font.weight = 500;
    Chart.defaults.plugins.tooltip.cornerRadius = 4;
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.caretSize = 0;
    Chart.defaults.plugins.tooltip.usePointStyle = true;
    Chart.defaults.plugins.tooltip.labelPointStyle = "circle";
    Chart.defaults.plugins.tooltip.backgroundColor = "#041f35";
    Chart.defaults.plugins.tooltip.mode = "index";
    Chart.defaults.plugins.tooltip.boxPadding = 2;
    Chart.defaults.plugins.tooltip.boxHeight = 11;
    Chart.defaults.plugins.tooltip.bodySpacing = 3;
    Chart.defaults.plugins.tooltip.multiKeyBackground = "rgb(0,0,0,0)";
    Chart.defaults.interaction.intersect = false;
    Chart.defaults.interaction.mode = "x";

    const typeChartData = {
      labels: typeyear,
      datasets: [
        {
          // [0]
          label: "Others",
          backgroundColor: "#0c67ac",
          data: count_othertype,
        },
        {
          // [1]
          label: "Mobile App",
          backgroundColor: "#2d9cf1",
          data: count_mobile,
        },
        {
          // [2]
          label: "Desktop App",
          backgroundColor: "#75bef6",
          data: count_desktop,
        },
        {
          // [3]
          label: "Website",
          backgroundColor: "#bde0fb",
          data: count_website,
        },
      ],
    }

    const typeChartConfig = {
      type: "bar",
      data: typeChartData,

      options: {
        animation: {
          duration: 0,
        },

        scales: {
          x: {
            stacked: true,
          },

          y: {
            stacked: true,
          },

          yAxes: [
            {
              gridLines: {
                display: true,
                color: "#e8eff6",
              },
              stacked: true,
            },
          ],

          xAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
              gridLines: {
                display: true,
                color: "#e8eff6",
              },
              stacked: true,
            },
          ],
        },

        maintainAspectRatio: false,

        plugins: {
          legend: {
            display: false,
          },

          tooltip: {
            itemSort: function (a, b) {
              return b.datasetIndex - a.datasetIndex;
            },
            callbacks: {
              footer: function (items) {
                return "Total: " + items.reduce((a, b) => a + b.parsed.y, 0);
              },
            },
          },
        },
      },
    };

    const typeChart = new Chart(
      document.getElementById('typeChart').getContext("2d"),
      typeChartConfig
    );
  </script>

  <script type="text/javascript">
    const count_cyber = <?php echo json_encode($count_cyber); ?>;
    const count_msi = <?php echo json_encode($count_msi); ?>;
    const count_rib = <?php echo json_encode($count_rib); ?>;
    const count_otherconc = <?php echo json_encode($count_otherconc); ?>;
    const concyear = <?php echo json_encode($concyear); ?>;

    Chart.defaults.font.family = "Inter";
    Chart.defaults.font.size = 15;
    Chart.defaults.color = "#041f35";
    Chart.defaults.font.weight = 500;
    Chart.defaults.plugins.tooltip.cornerRadius = 4;
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.caretSize = 0;
    Chart.defaults.plugins.tooltip.usePointStyle = true;
    Chart.defaults.plugins.tooltip.labelPointStyle = "circle";
    Chart.defaults.plugins.tooltip.backgroundColor = "#041f35";
    Chart.defaults.plugins.tooltip.mode = "index";
    Chart.defaults.plugins.tooltip.boxPadding = 2;
    Chart.defaults.plugins.tooltip.boxHeight = 11;
    Chart.defaults.plugins.tooltip.bodySpacing = 3;
    Chart.defaults.plugins.tooltip.multiKeyBackground = "rgb(0,0,0,0)";
    Chart.defaults.interaction.intersect = false;
    Chart.defaults.interaction.mode = "x";

    const concChartData = {
      labels: concyear,
      datasets: [
        {
            // [0]
            label: "Others",
            backgroundColor: "#0c67ac",
            data: count_otherconc,
          },
          {
            // [1]
            label: "Engineering and Business Intelligence",
            backgroundColor: "#2d9cf1",
            data: count_rib,
          },
          {
            // [2]
            label: "Management Information System",
            backgroundColor: "#75bef6",
            data: count_msi,
          },
          {
            // [3]
            label: "Cybersecurity",
            backgroundColor: "#bde0fb",
            data: count_cyber,
          },
      ],
    }

    const concChartConfig = {
      type: "bar",
      data: concChartData,

      options: {
        animation: {
          duration: 0,
        },

        scales: {
          x: {
            stacked: true,
          },

          y: {
            stacked: true,
          },

          yAxes: [
            {
              gridLines: {
                display: true,
                color: "#e8eff6",
              },
              stacked: true,
            },
          ],

          xAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
              gridLines: {
                display: true,
                color: "#e8eff6",
              },
              stacked: true,
            },
          ],
        },

        maintainAspectRatio: false,

        plugins: {
          legend: {
            display: false,
          },

          tooltip: {
            itemSort: function (a, b) {
              return b.datasetIndex - a.datasetIndex;
            },
            callbacks: {
              footer: function (items) {
                return "Total: " + items.reduce((a, b) => a + b.parsed.y, 0);
              },
            },
          },
        },
      },
    };

    const concentrationChart = new Chart(
      document.getElementById('concentrationChart').getContext("2d"),
      concChartConfig
    );
  </script>

  <script>
    /* When the user clicks on the button, 
      toggle between hiding and showing the dropdown content */
    function myFunction() {
      document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
      if (!event.target.matches(".dropbtn")) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
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
    /* When the user clicks on the button, 
      toggle between hiding and showing the dropdown content */
    function myFunction2() {
      document.getElementById("myDropdown2").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
      if (!event.target.matches(".dropbtn")) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
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
    /* When the user clicks on the button, 
      toggle between hiding and showing the dropdown content */
    function myFunction3() {
      document.getElementById("myDropdown3").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
      if (!event.target.matches(".dropbtn")) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
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
</body>

</html>