<?php
include "connect.php";
include "loginfix.php";

$user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<nav>
  <div class="navbar-start">
    <div style="padding-right: 13px">
      <a href="home.php">
        <img src="photos\favicon.png" width="43px" height="43px" />
      </a>
    </div>
    <div class="title">
      <a href="home.php">Innovation System</a>
    </div>
  </div>
  <div class="navbar-end">
    <div style="padding-right: 34px">
      <a class="navlinks" href="home.php">Homepage</a>
      <a class="navlinks" href="catalogue.php">Catalogue</a>
    </div>
    <div>
      <i class="bx bx-search icon-search" aria-hidden="trues" style="
              padding-right: 5px;
              font-size: 25px;
              z-index: 999;
              cursor: pointer;
              padding-top: 0.3rem;
            "></i>
      <div class="search-form">
        <div class="search-flex">
          <div>
            <i class="bx bx-search" style="font-size: 25px; z-index: 999; padding-bottom: 0.9rem"></i>
          </div>
          <div>
            <form action="catalogue.php" method="get">
              <input type="search" name="search" placeholder="Click here to search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';?>"/>
              <input type="hidden" name="user" value="<?php echo $user?>">
            </form>
          </div>
          <div>
            <i class="bx bx-x search-close" style="
                    font-size: 32px;
                    z-index: 999;
                    padding-bottom: 0.9rem;
                    cursor: pointer;
                  "></i>
          </div>
        </div>
      </div>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') : ?>
        <i id="userIcon" class='bx bx-user-circle profilebtn' onclick="profileFunction()" style="font-size: 25px; padding-top: 0.3rem;"></i>
        <div id="profileDropdown" class="user-dropdown">
          <a class="droplinks" href="user.php">Dashboard</a>
          <a class="droplinks" href="submission.php">Submit</a>
          <a class="droplinks" href="help.php">Help</a>
          <a class="droplinks" onclick="confirmLogout()">Logout</a>
        </div>
      <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
        <i id="userIcon" class="bx bx-shield profilebtn" onclick="profileFunction()" style="font-size: 25px; padding-top: 0.3rem"></i>
        <div id="profileDropdown" class="user-dropdown">
          <a class="droplinks" href="admin.php">Dashboard</a>
          <a class="droplinks" onclick="confirmLogout()">Logout</a>
        </div>
      <?php else : ?>
        <a href="login.php"><i id="userIcon" class="bx bx-log-in-circle" style="font-size: 26px; padding-top: 0.3rem"></i></a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="navpadding"></div>

<script>
  function confirmLogout() {
    var confirmLogout = confirm("Are you sure you want to log out?");
    if (confirmLogout) {
      alert("Logout successful!");
      window.location.href = 'logout.php';
    } else {
      alert("Logout canceled.");
    }
  }
</script>