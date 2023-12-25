<?php

include "connect.php";
include "header.php";

$category = isset($_GET['category']) ? $_GET['category'] : '0';
$type = isset($_GET['type']) ? $_GET['type'] : '0';
$concentration = isset($_GET['concentration']) ? $_GET['concentration'] : '0';
$date = isset($_GET['date']) ? $_GET['date'] : '2018-01-01 - ' . date('Y-m-d');
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
list($start, $end) = explode(' - ', $date);

$limit = 9; // Number of records per page
$offset = ($page - 1) * $limit;

$total_pages_sql = "SELECT COUNT(*) as count, innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType, innovdata.IDCateg, innovdata.IDConc, innovdata.IDType, innovdata.Description
FROM innovdata 
JOIN type ON innovdata.IDType = type.IDType 
JOIN concentration ON innovdata.IDConc = concentration.IDConc 
JOIN category ON innovdata.IDCateg = category.IDCateg ";

// Display data from innovdata
$query = "SELECT innovdata.IDInnov, innovdata.NameInnov, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType, innovdata.IDCateg, innovdata.IDConc, innovdata.IDType, innovdata.Description
          FROM innovdata 
          JOIN type ON innovdata.IDType = type.IDType 
          JOIN concentration ON innovdata.IDConc = concentration.IDConc 
          JOIN category ON innovdata.IDCateg = category.IDCateg";

// All count
$allCount = "SELECT COALESCE(COUNT(*), 0) AS total FROM innovdata JOIN category ON innovdata.IDCateg = category.IDCateg JOIN type ON innovdata.IDType = type.IDType JOIN concentration ON innovdata.IDConc = concentration.IDConc ";

// Category count
$categoryCount = "SELECT category.NameCateg, category.IDCateg, COALESCE(COUNT(*), 0) as categoryCount 
                  FROM innovdata 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  JOIN type ON innovdata.IDType = type.IDType 
                  JOIN concentration ON innovdata.IDConc = concentration.IDConc ";

// Type count
$typeCount = "SELECT type.NameType, type.IDType, COALESCE(COUNT(*), 0) as typeCount 
              FROM innovdata 
              JOIN type ON innovdata.IDType = type.IDType 
              JOIN concentration ON innovdata.IDConc = concentration.IDConc 
              JOIN category ON innovdata.IDCateg = category.IDCateg ";

// Concentration count
$concentrationCount = "SELECT concentration.NameConc, concentration.IDConc, COALESCE(COUNT(*), 0) as concentrationCount 
                       FROM innovdata 
                       JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                       JOIN type ON innovdata.IDType = type.IDType 
                       JOIN category ON innovdata.IDCateg = category.IDCateg ";

if (!empty($user)) {
  $query .= " JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
              JOIN user ON userinnov.IDUser = user.IDUser ";
  $total_pages_sql .= " JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                        JOIN user ON userinnov.IDUser = user.IDUser ";
  $allCount .= " JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                 JOIN user ON userinnov.IDUser = user.IDUser ";
                 $categoryCount .= " JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                 JOIN user ON userinnov.IDUser = user.IDUser ";
                 $typeCount .= " JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                 JOIN user ON userinnov.IDUser = user.IDUser ";
                 $concentrationCount .= " JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                 JOIN user ON userinnov.IDUser = user.IDUser ";
}

$query .= " WHERE innovdata.Status = 'Approved'";
$total_pages_sql .= " WHERE innovdata.Status = 'Approved'";
$allCount .= " WHERE innovdata.Status = 'Approved'";
$categoryCount .= " WHERE innovdata.Status = 'Approved'";
$typeCount .= " WHERE innovdata.Status = 'Approved'";
$concentrationCount .= " WHERE innovdata.Status = 'Approved'";

if ($category != '0') {
  $query .= " AND innovdata.IDCateg=$category";
  $total_pages_sql .= " AND innovdata.IDCateg=$category";
}

if (!empty($user)) {
  $query .= " AND userinnov.IDUser='$user'";
  $total_pages_sql .= " AND userinnov.IDUser='$user'";
  $allCount .= " AND userinnov.IDUser='$user'";
  $categoryCount .= " AND userinnov.IDUser='$user'";
  $typeCount .= " AND userinnov.IDUser='$user'";
  $concentrationCount .= " AND userinnov.IDUser='$user'";
}

if ($type != '0') {
  $query .= " AND innovdata.IDType=$type";
  $total_pages_sql .= " AND innovdata.IDType=$type";
}

if ($concentration != '0') {
  $query .= " AND innovdata.IDConc=$concentration";
  $total_pages_sql .= " AND innovdata.IDConc=$concentration";
}

if (!empty($start) && !empty($end)) {
  $query .= " AND innovdata.CreDate BETWEEN '$start' AND '$end'";
  $total_pages_sql .= " AND innovdata.CreDate BETWEEN '$start' AND '$end'";
}

if (!empty($search)) {
  $query .= " AND (innovdata.NameInnov LIKE '%$search%' OR category.NameCateg LIKE '%$search%' OR type.NameType LIKE '%$search%' OR concentration.NameConc LIKE '%$search%' OR innovdata.Description LIKE '%$search%')";
  $total_pages_sql .= " AND (innovdata.NameInnov LIKE '%$search%' OR category.NameCateg LIKE '%$search%' OR type.NameType LIKE '%$search%' OR concentration.NameConc LIKE '%$search%' OR innovdata.Description LIKE '%$search%')";
  $allCount .= " AND (innovdata.NameInnov LIKE '%$search%' OR category.NameCateg LIKE '%$search%' OR type.NameType LIKE '%$search%' OR concentration.NameConc LIKE '%$search%' OR innovdata.Description LIKE '%$search%')";
  $categoryCount .= " AND (innovdata.NameInnov LIKE '%$search%' OR category.NameCateg LIKE '%$search%' OR type.NameType LIKE '%$search%' OR concentration.NameConc LIKE '%$search%' OR innovdata.Description LIKE '%$search%')";
  $typeCount .= " AND (innovdata.NameInnov LIKE '%$search%' OR category.NameCateg LIKE '%$search%' OR type.NameType LIKE '%$search%' OR concentration.NameConc LIKE '%$search%' OR innovdata.Description LIKE '%$search%')";
  $concentrationCount .= " AND (innovdata.NameInnov LIKE '%$search%' OR category.NameCateg LIKE '%$search%' OR type.NameType LIKE '%$search%' OR concentration.NameConc LIKE '%$search%' OR innovdata.Description LIKE '%$search%')";
}

$query .= " ORDER BY innovdata.CreDate DESC LIMIT $offset, $limit";
$categoryCount .= " GROUP BY category.NameCateg ORDER BY `category`.`IDCateg` ASC";
$typeCount .= " GROUP BY type.NameType ORDER BY `type`.`IDType` ASC";
$concentrationCount .= "GROUP BY concentration.NameConc ORDER BY `concentration`.`IDConc` ASC";

if (!empty($user)) {
  $namequery = "SELECT user.Username FROM user WHERE user.IDUser='$user'";
  $nameresult = $koneksi->query($namequery);
  $namerow = $nameresult->fetch_assoc();
  $name = $namerow['Username'];
}

$total_pages_result = $koneksi->query($total_pages_sql);
$total_pages = ceil($total_pages_result->fetch_assoc()['count'] / $limit);
$result = mysqli_query($koneksi, $query);

$allCountResult = mysqli_query($koneksi, $allCount);
$allCountRow = mysqli_fetch_assoc($allCountResult);
$allCountTotal = $allCountRow['total'];

$categoryCountResult = mysqli_query($koneksi, $categoryCount);
$categoryCounts = array();

while ($row = mysqli_fetch_assoc($categoryCountResult)) {
  $categoryName = $row['NameCateg'];
  $categoryID = $row['IDCateg'];
  $categoryCountTotal = $row['categoryCount'];
  $categoryCounts[$categoryName] = $categoryCountTotal;
}

$typeCountResult = mysqli_query($koneksi, $typeCount);
$typeCounts = array();

while ($row = mysqli_fetch_assoc($typeCountResult)) {
  $typeName = $row['NameType'];
  $typeID = $row['IDType'];
  $typeCountTotal = $row['typeCount'];
  $typeCounts[$typeName] = $typeCountTotal;
}

$concentrationCountResult = mysqli_query($koneksi, $concentrationCount);
$concentrationCounts = array();

while ($row = mysqli_fetch_assoc($concentrationCountResult)) {
  $concentrationName = $row['NameConc'];
  $concentrationID = $row['IDConc'];
  $concentrationCountTotal = $row['concentrationCount'];
  $concentrationCounts[$concentrationName] = $concentrationCountTotal;
}
?>

<html>

<head>
  <title>Catalogue of Innovations | SIFORS Innovation System</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="catalogue.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
  <script src="userdropdown.js"></script>
</head>

<body>
  <div class="headline catalogue">
    <div class="headline-content">
      <h1 class="headline-title">Catalogue of Innovations</h1>
      <p>From websites to mobile apps, the Information System study program has created a lot of unique innovations.
      </p>
    </div>
  </div>

  <div class="container">
    <div class="catalogue-container">
      <div>
        <form action="" method="get">
          <div class="section-head" style="margin: 0">
            <div>
              <h1 class="section-title" style="margin: 0">Filters</h1>
            </div>
            <div class="navbar-end" style="margin: 0">
              <input type="submit" value="Submit" class="general-button" style="padding: 8px 12px; margin: 0">
            </div>
          </div>
          <div class="filters-container">
            <button class="accordion">Categories</button>
            <div class="panel">
              <div class="filter-container">
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="category" value="0" <?php echo ($category == '0') ? 'checked' : ''; ?>>
                    <span class="filter-text">All</span>
                  </label>
                  <div class="count">
                    <?php echo $allCountTotal ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="category" value="1" <?php echo ($category == '1') ? 'checked' : ''; ?>>
                    <span class="filter-text">Thesis</span>
                  </label>
                  <div class="count">
                    <?php echo $categoryCounts['Thesis'] ?? 0 ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="category" value="2" <?php echo ($category == '2') ? 'checked' : ''; ?>>
                    Internship
                  </label>
                  <div class="count">
                    <?php echo $categoryCounts['Internship'] ?? 0 ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="category" value="3" <?php echo ($category == '3') ? 'checked' : ''; ?>>
                    Others
                  </label>
                  <div class="count">
                    <?php echo $categoryCounts['Others'] ?? 0 ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="filters-container">
            <button class="accordion">Type</button>
            <div class="panel">
              <div class="filter-container">
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="type" value="0" <?php echo ($type == '0') ? 'checked' : ''; ?>>
                    <span class="filter-text">All</span>
                  </label>
                  <div class="count">
                    <?php echo $allCountTotal ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="type" value="1" <?php echo ($type == '1') ? 'checked' : ''; ?>>
                    <span class="filter-text">Website</span>
                  </label>
                  <div class="count">
                    <?php echo $typeCounts['Website'] ?? 0 ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="type" value="2" <?php echo ($type == '2') ? 'checked' : ''; ?>>
                    <span class="filter-text">Desktop App</span>
                  </label>
                  <div class="count">
                    <?php echo $typeCounts['Desktop App'] ?? 0 ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="type" value="3" <?php echo ($type == '3') ? 'checked' : ''; ?>>
                    <span class="filter-text">Mobile App</span>
                  </label>
                  <div class="count">
                    <?php echo $typeCounts['Mobile App'] ?? 0 ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="type" value="4" <?php echo ($type == '4') ? 'checked' : ''; ?>>
                    <span class="filter-text">Other</span>
                  </label>
                  <div class="count">
                    <?php echo $typeCounts['Others'] ?? 0 ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="filters-container">
            <button class="accordion">Concentration</button>
            <div class="panel">
              <div class="filter-container">
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="concentration" value="0" <?php echo ($concentration == '0') ? 'checked' : ''; ?>>
                    <span class="filter-text">All</span>
                  </label>
                  <div class="count">
                    <?php echo $allCountTotal ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="concentration" value="1" <?php echo ($concentration == '1') ? 'checked' : ''; ?>>
                    <span class="filter-text">Cybersecurity</span>
                  </label>
                  <div class="count">
                    <?php echo $concentrationCounts['Cybersecurity'] ?? 0 ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="concentration" value="2" <?php echo ($concentration == '2') ? 'checked' : ''; ?>>
                    <span class="filter-text">Management Information System</span>
                  </label>
                  <div class="count">
                    <?php echo $concentrationCounts['Management Information System'] ?? 0 ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="concentration" value="3" <?php echo ($concentration == '3') ? 'checked' : ''; ?>>
                    <span class="filter-text">Engineering and Business Intelligence</span>
                  </label>
                  <div class="count">
                    <?php echo $concentrationCounts['Engineering and Business Intelligence'] ?? 0 ?>
                  </div>
                </div>
                <div class="filter-line">
                  <label class="filter">
                    <input type="radio" name="concentration" value="4" <?php echo ($concentration == '4') ? 'checked' : ''; ?>>
                    <span class="filter-text">Others</span>
                  </label>
                  <div class="count">
                    <?php echo $concentrationCounts['Others'] ?? 0 ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="filters-container">
            <button class="accordion">Date</button>
            <div class="panel">
              <div class="filter-container">
                <div class="input-container">
                  <i class="bx bx-calendar-alt"></i>
                  <input id="datepicker" name="date" placeholder="Insert date here..." />
                </div>
              </div>
            </div>
          </div>
      </div>
      <input type="hidden" name="search" value="<?php echo $search ?>">
      <input type="hidden" name="user" value="<?php echo $user ?>">
      </form>
      <div>
        <?php
        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search']) && !empty($_GET['search']) && empty($_GET['user'])) {
          echo '<div class="section-title" style="margin-bottom: 20px;">Innovations for "' . htmlspecialchars($_GET['search']) . '"</div>';
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search']) && !empty($_GET['search']) && !empty($_GET['user'])) {
          echo '<div class="section-title" style="margin-bottom: 20px;">Innovations for "' . htmlspecialchars($_GET['search']) . '" under "' . htmlspecialchars($name) . '"</div>';
        } else if (empty($_GET['search']) && !empty($_GET['user'])) {
          echo '<div class="section-title" style="margin-bottom: 20px;">Innovations under "' . htmlspecialchars($name) . '"</div>';
        } else {
          echo '<div class="section-title" style="margin-bottom: 20px;">Innovations</div>';
        }
        ?>

        <?php
        if ($result->num_rows > 0) {
          $counter = 0;

          while ($row = mysqli_fetch_assoc($result)) {

            $IDInnov = $row['IDInnov'];
            $nameInnov = $row['NameInnov'];
            $creDate = date("F j, Y", strtotime($row['CreDate']));
            $SubmDate = date("F j, Y", strtotime($row['SubmDate']));
            $categoryName = $row['NameCateg'];
            $images = explode(",", $row['Img']);

            if ($counter == 0 && $counter % 3 == 0) {
              echo '<div class="owl-carousel owl-theme">';
              echo '<div class="item item-3">';
            }

            echo '<div class="items item-3" onclick="window.open(\'innovation.php?id=' . $IDInnov . '\');">';
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
          echo '</div>';
          echo '</div>';
          echo '<div class="pagination-container" style="margin-top: 25px;">';

          $prev_page = $page - 1;
          echo "<a href='catalogue.php?category=$category&type=$type&concentration=$concentration&date=$date&search=$search&user=$user&page=$prev_page'><button class='swipe-button white'><i class='bx bx-chevron-left' style='font-size: 30px;'></i></button></a>";
          echo '<div style="text-align: center;">';

          for ($i = 1; $i <= $total_pages; $i++) {
            $buttonClass = ($i == $page) ? 'swipe-button number' : 'swipe-button white number';
            echo "<a href='catalogue.php?category=$category&type=$type&concentration=$concentration&date=$date&search=$search&user=$user&page=$i'><button class='$buttonClass'>$i</button></a>";
          }

          echo '</div>';
          echo '<div style="text-align: right;">';

          $next_page = $page + 1;
          echo "<a href='catalogue.php?category=$category&type=$type&concentration=$concentration&date=$date&search=$search&user=$user&page=$next_page' class='pagination-link'><button class='swipe-button white'><i class='bx bx-chevron-right' style='font-size: 30px;'></i></button></a>";

          echo '</div>';
          echo '</div>';
        } else {
          echo '<div class="creators-info info" style="width: 10fr!important">';
          echo '<div>No results found.</div>';
          echo '<div><i class=\'bx bxs-info-circle right\' style="font-size: 22px; line-height: 1;"></i></div>';
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
        margin: 0,
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
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      var panel = acc[i].nextElementSibling;
      panel.style.maxHeight = panel.scrollHeight + "px";
      acc[i].onclick = function() {
        this.classList.toggle("turnedon");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        }
      }
    }
  </script>

  <script>
    const currentDate = new Date();
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
    const day = String(currentDate.getDate()).padStart(2, '0');
    const formattedCurrentDate = `${year}-${month}-${day}`;

    const picker = new easepick.create({
      element: document.getElementById('datepicker'),
      css: [
        'https://cdn.jsdelivr.net/npm/@easepick/core@1.2.1/dist/index.css',
        'https://cdn.jsdelivr.net/npm/@easepick/range-plugin@1.2.1/dist/index.css',
        'https://cdn.jsdelivr.net/npm/@easepick/preset-plugin@1.2.1/dist/index.css',
        'easepick.css',
      ],
      zIndex: 9999999,
      AmpPlugin: {
        dropdown: {
          minYear: 2018,
          months: true,
          years: true,
        },
        resetButton: true,
      },
      plugins: ['RangePlugin', 'PresetPlugin', 'AmpPlugin'],
      PresetPlugin: {
        position: 'left',
      },
      RangePlugin: {
        startDate: '<?php echo $start; ?>',
        endDate: '<?php echo $end; ?>',
      },
    });
  </script>
</body>

</html>