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
        <button class="accordion">What if the innovation we upload is rejected?</button>
        <div class="panel">
          <div class="filter-container">
            You can edit the innovation again and then resubmit it so the admin can review your innovation once more. Please note that if you want to change the images you have submitted, you will have to resubmit the form from scratch instead.
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">If my innovation has been approved, can I edit the innovation?</button>
        <div class="panel">
          <div class="filter-container">
            Unfortunately, innovations that have already been approved will no longer be editable. Please contact the admin directly to submit an edit or deletion request for your innovation instead.
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">What is the process of validation from pending to approved?</button>
        <div class="panel">
          <div class="filter-container">
            The validation process will be carried out by the admin, after which the admin will check the suitability of the format entered by the user. If the format is appropriate then the admin will approve, and conversely the admin will reject if the format entered is not appropriate.
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">What are the indications that our innovation will be rejected?</button>
        <div class="panel">
          <div class="filter-container">
            An indication that your innovation will be rejected is a mismatch in format, for example: the role of a creator is supposed to be a lecturer but their role is inputted as student instead.
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">Can I make a new account or reset my password?</button>
        <div class="panel">
          <div class="filter-container">
            The data of the accounts of this system is pulled from the accounts that have already been listed in UNDIKSHA's SSO service. If you want to reset your password or make a new account, please contact UNDIKSHA's UPA TIK directly.
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">How to add creators who aren't from the SIFORS study program?</button>
        <div class="panel">
          <div class="filter-container">
            You can put those creators on the description box of the innovation, as the creators field is only able to contain creators from the Information System study program.
          </div>
        </div>
      </div>
    </div>

    <div class="innovation-creators">
      <div class="filters-container">
        <button class="accordion">What is "Other" in Categories, Types, and Concentrations?</button>
        <div class="panel">
          <div class="filter-container">
            Other in Categories means innovations that are for competitions, research, and other purposes. Meanwhile, Other in Types means innovations that are in the form of research papers, system anaylses, and other types. Lastly, Other in Concentrations means innovations that do not fall in the usual concentrations in the Information System study program.
          </div>
        </div>
      </div>

      <div class="filters-container">
        <button class="accordion">How do I contact the creator(s) of an innovation?</button>
        <div class="panel">
          <div class="filter-container">
            You can contact any of the creators through the email address of the creator you'd like to contact that is listed in the innovation's page.
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