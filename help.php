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
        <button class="accordion">Question 1</button>
        <div class="panel">
          <div class="filter-container">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dapibus venenatis mi, vel consectetur urna hendrerit eu. Sed ullamcorper sapien ut justo vestibulum, a hendrerit ligula malesuada.
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">Question 2</button>
        <div class="panel">
          <div class="filter-container">
            Nulla facilisi. Fusce at ligula nec dui mattis cursus. Sed auctor eros ut nunc fermentum, vel efficitur nulla consequat. Phasellus ultricies ligula in purus bibendum, non ultricies neque blandit.
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">Question 3</button>
        <div class="panel">
          <div class="filter-container">
            Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In hac habitasse platea dictumst. Suspendisse feugiat lectus vitae diam aliquet, sit amet convallis justo ultrices.
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">Question 4</button>
        <div class="panel">
          <div class="filter-container">
            Quisque id massa in nisl bibendum dapibus. Maecenas rhoncus erat nec justo ultrices, vel lacinia ligula facilisis. Nunc fermentum justo id augue consequat, vel tincidunt orci accumsan.
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">Question 5</button>
        <div class="panel">
          <div class="filter-container">
            Aliquam non feugiat purus. Sed suscipit felis vitae turpis sodales, id aliquet felis dictum. Integer tristique, dolor vel fermentum mattis, arcu velit consectetur justo, in euismod lacus justo sit amet nulla.
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">Question 6</button>
        <div class="panel">
          <div class="filter-container">
            Etiam scelerisque justo et justo varius ultricies. Curabitur quis nisl sed est dictum iaculis vel vitae neque. Sed ullamcorper nisl eu urna fringilla, eu lacinia odio congue.
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">Question 7</button>
        <div class="panel">
          <div class="filter-container">
            Fusce a elit in dolor vestibulum lacinia. Pellentesque quis ipsum vel tortor cursus luctus. Suspendisse eget risus eu ligula tincidunt gravida.
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">Question 8</button>
        <div class="panel">
          <div class="filter-container">
            Integer cursus justo eu tincidunt aliquet. Vivamus ac quam nec ex cursus varius. Aliquam quis nunc vel justo pulvinar fermentum.
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