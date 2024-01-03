<?php
include "connect.php";
include "loginfix.php";

$user = isset($_GET['user']) ? $_GET['user'] : '';
?>

<head>
  <link rel="apple-touch-icon" sizes="180x180" href="icons/apple-touch-icon.png?v=1">
  <link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png?v=1">
  <link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png?v=1">
  <link rel="manifest" href="icons/site.webmanifest">
  <link rel="mask-icon" href="icons/safari-pinned-tab.svg?v=1" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
</head>

<style>
  .reminder {
    width: 100%;
    height: 100%;
    z-index: 999999999999999999999999;
    display: none;
    background: #0c67ab;
    color: #fff !important;
    position: fixed;
    top: 0;
    left: 0;
    padding: 75px;
    font-size: 20px;
  }
@media only screen and (min-width: 1px) and (max-width: 1024px) {
  .reminder { display: block; }
}
</style>

<div class="reminder">
  <center style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">This site is only viewable via desktop. Sorry about that.</center>
</div>

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