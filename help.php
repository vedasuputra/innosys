<?php

include "header.php";
include "connect.php";

?>

<html>

<head>
  <title>Help Center | SIFORS Innovation System</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="catalogue.css">
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="help.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="userdropdown.js"></script>
</head>

<body>
  <div class="headline help">
    <div class="headline-content">
      <h1 class="headline-title">Help Center</h1>
      <p>If you can't find your question on the list, feel free to contact the admin below.</p>
      <button onclick="window.open('#');" type="button" class="headline-button">
        Contact Admin
      </button>
    </div>
  </div>

  <div class="container" style="margin-top: 2.75rem;">
    <h1 class="section-title" style="margin-bottom: 25px">Frequently Asked Questions</h1>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">Type</button>
        <div class="panel">
          <div class="filter-container">
            a
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">Type</button>
        <div class="panel">
          <div class="filter-container">
            a
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">Type</button>
        <div class="panel">
          <div class="filter-container">
            a
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">Type</button>
        <div class="panel">
          <div class="filter-container">
            a
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">Type</button>
        <div class="panel">
          <div class="filter-container">
            a
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">Type</button>
        <div class="panel">
          <div class="filter-container">
            a
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">Type</button>
        <div class="panel">
          <div class="filter-container">
            a
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">Type</button>
        <div class="panel">
          <div class="filter-container">
            a
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include "footer.php" ?>

  <script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("turnedon");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        }
      });
    }
  </script>

</body>

</html>