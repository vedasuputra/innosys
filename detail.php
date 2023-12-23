<?php

error_reporting(E_ALL & ~E_NOTICE);
session_start();

include "connect.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  session_unset();
  echo "<script>
          alert('Error: You must be logged in as a user to access this page.');
          window.location.href = 'login.php';
        </script>";
  exit();
}

$loggedInUserID = $_SESSION['username'];

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  echo "<script>
          alert('Error: An innovation ID is required.');
          window.history.back();
        </script>";
  exit();
}

$query = "SELECT innovdata.IDInnov, innovdata.NameInnov, innovdata.Description, innovdata.Status, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, innovdata.Link, innovdata.LinkYouTube, category.NameCateg, concentration.NameConc, type.NameType, userinnov.IDUser, user.Username
          FROM innovdata 
          JOIN type ON innovdata.IDType = type.IDType 
          JOIN concentration ON innovdata.IDConc = concentration.IDConc 
          JOIN category ON innovdata.IDCateg = category.IDCateg 
          JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
          JOIN user ON userinnov.IDUser = user.IDUser
          WHERE innovdata.IDInnov='$id'
          ORDER BY `innovdata`.`creDate` DESC";

$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
  echo "<script>
          alert('Error: Innovation with this ID can\'t be found.');
          window.history.back();
        </script>";
  exit();
}

// Your existing code for processing the row goes here
$IDInnov = $row['IDInnov'];
$nameInnov = $row['NameInnov'];
$description = $row['Description'];
$status = $row['Status'];
$link = $row['Link'];
$linkyoutube = $row['LinkYouTube'];
$nameCateg = $row['NameCateg'];
$nameType = $row['NameType'];
$nameConc = $row['NameConc'];
$creDate = date("Y-m-d", strtotime($row['CreDate']));
$SubmDate = date("Y-m-d", strtotime($row['SubmDate']));
$images = explode(",", $row['Img']);
$username = $row['Username'];
$id_user_array = array($row['IDUser']);

if ($status == 'Approved') {
  echo "<script>
          alert('Error: Innovation with this ID has been approved by the admin. Go to the approved innovation page?');
          window.location.href = 'innovation.php?id=' + $id;
        </script>";
  exit();
}

$creatorsQuery = "SELECT  userinnov.IDUser, user.Username 
                  FROM innovdata 
                  JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
                  JOIN user ON userinnov.IDUser = user.IDUser
                  WHERE innovdata.IDInnov='$id'";

$creatorsResult = mysqli_query($koneksi, $creatorsQuery);
$creatorsResults = array();

while ($creatorsRow = mysqli_fetch_assoc($creatorsResult)) {
  $username = $creatorsRow['Username'];
  $IDUser = $creatorsRow['IDUser'];
  $creatorsResults[$IDUser] = array(
    'username' => $username,
    'IDUser' => $IDUser
  );
}

foreach ($creatorsResults as $IDUser => $creatorData) {
  $IDUser = $creatorData['IDUser'];
  $username = $creatorData['username'];
}

if (!array_key_exists($loggedInUserID, $creatorsResults) && $_SESSION['role'] !== 'admin') {
  // Redirect to a page indicating unauthorized access or handle it in another way
  echo "<script>
          alert('Error: You are not a part of this innovation\'s creators.');
          window.history.back();
        </script>";
  exit();
}

if ($status == 'Rejected') {
  $rejectedQuery = "SELECT validation.Note 
                  FROM innovdata 
                  JOIN validation ON innovdata.IDInnov = validation.IDInnov
                  WHERE innovdata.IDInnov='$id' AND innovdata.Status = 'Rejected'";

  $rejectedResult = mysqli_query($koneksi, $rejectedQuery);
  $rejectedRow = mysqli_fetch_assoc($rejectedResult);

  $note = $rejectedRow['Note'];
}

if (isset($_POST['deleteButton'])) {
  // Check if the user is an admin
  if ($_SESSION['role'] == 'admin') {
    $id = $_POST['recordId'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM innovdata WHERE innovdata.IDInnov = '$id'";
    $deleteResult = mysqli_query($koneksi, $deleteQuery);

    exit; // Stop further execution after handling the deletion
  } else {
    echo "<script>
      alert('Error: You do not have the permission to perform this action.');
      window.history.back();
    </script>";
    exit;
  }
}

if (isset($_POST['approveButton'])) {
  // Check if the user is an admin
  if ($_SESSION['role'] == 'admin') {
    // Perform the status update
    $approveQuery = "UPDATE innovdata SET Status = 'Approved' WHERE IDInnov = '$id'";
    $approveResult = mysqli_query($koneksi, $approveQuery);

    if ($approveResult) {
      // Insert data into 'validation' table
      $approveValidationQuery = "INSERT INTO validation (IDInnov, IDValid, Decision, Note) VALUES ('$id', '$id', 'Approved', '')";
      $approveValidationResult = mysqli_query($koneksi, $approveValidationQuery);
    }
  } else {
    echo "<script>
            alert('Error: You do not have the permission to perform this action.');
            window.history.back();
          </script>";
    exit();
  }
}

if (isset($_POST['rejectButton'])) {
  // Check if the user is an admin
  if ($_SESSION['role'] == 'admin') {
    // Perform the status update
    $rejectQuery = "UPDATE innovdata SET Status = 'Rejected' WHERE IDInnov = '$id'";
    $rejectResult = mysqli_query($koneksi, $rejectQuery);

    if ($rejectResult) {
      $Reason = mysqli_real_escape_string($koneksi, $_POST['Reason']);
      // Insert data into 'validation' table
      $rejectValidationQuery = "INSERT INTO validation (IDInnov, IDValid, Decision, Note) VALUES ('$id', '$id', 'Rejected', '$Reason')";
      $rejectValidationResult = mysqli_query($koneksi, $rejectValidationQuery);
    }
  } else {
    echo "<script>
            alert('Error: You do not have the permission to perform this action.');
            window.history.back();
          </script>";
    exit();
  }
}

if (isset($_POST['editReasonButton'])) {
  // Check if the user is an admin
  if ($_SESSION['role'] == 'admin') {
    $EditReason = mysqli_real_escape_string($koneksi, $_POST['EditReason']);
    // Perform the status update
    $editReasonQuery = "UPDATE validation SET Note = '$EditReason' WHERE IDInnov = '$id'";
    $editReasonResult = mysqli_query($koneksi, $editReasonQuery);
  } else {
    echo "<script>
            alert('Error: You do not have the permission to perform this action.');
            window.history.back();
          </script>";
    exit();
  }
}

include "header.php";
?>

<html>

<head>
  <title>Review Form | SIFORS Innovation System</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="select2.css">
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="submission.css">
  <link rel="stylesheet" href="detail.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://christianbayer.github.io/image-uploader/dist/image-uploader.min.css">
  <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script src="userdropdown.js"></script>
</head>

<body>
  <div class="headline submission">
    <div class="headline-content">
      <h1 class="headline-title">Review Your Innovation</h1>
      <p>This is the innovation that have been submitted, where it could be accepted or rejected by the system's admin.</p>
    </div>
  </div>

  <div class="container">
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="section-head">
        <div>
          <h1 class="section-title">Review Form</h1>
        </div>
        <?php if ($_SESSION['role'] == 'admin') {
          echo '<div class="navbar-end">';
          echo '<div class="button-wrapper">';
          echo '<button class="swipe-button red delete-button" onclick="deleteRecord(' . $id . ')">';
          echo '<i class="bx bxs-trash-alt" style="font-size: 18px"></i>';
          echo '</button>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>

      <?php
      if ($status == 'Pending') {
        echo '<div class="creators-info info">';
        echo '<div>Submission is waiting to be reviewed by the system\'s administrator.</div>';
        echo '<div><span class="status right ' . $status . '">' . $status . '</span></div>';
        echo '</div>';
      } elseif ($status == 'Rejected' && $_SESSION['role'] != 'admin') {
        echo '<div class="creators-info danger">';
        echo '<div>Submission has been rejected because "' . $note . '." <strong><a href="edit.php?id=' . $id . '">Edit your submission?</a></strong></div>';
        echo '<div><span class="status right ' . $status . '">' . $status . '</span></div>';
        echo '</div>';
      } elseif ($status == 'Rejected' && $_SESSION['role'] == 'admin') {
        echo '<div class="creators-info danger">';
        echo '<div>Submission has been rejected because "' . $note . '" <strong><a class="modal-button" href="#myModal2">Edit the rejection reason?</a></strong></div>';
        echo '<div><span class="status right ' . $status . '">' . $status . '</span></div>';
        echo '</div>';

        echo '<div id="myModal2" class="modal">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h4><label for="EditReason">Edit reason of rejection</label></h4>';
        echo '<div class="close close_multi"><i class=\'bx bx-x\' style="line-height: 0.8"></i></div>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<textarea id="editReasonTextarea" name="EditReason" placeholder="Be as clear as possible.">' . $note . '</textarea>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<input type="submit" name="editReasonButton" value="Edit" class="submit red" style="margin-top: 0; padding-top: 12px; padding-bottom: 12px;" onclick="validateAndReject2(' . $id . ')">';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<script>';
        echo 'function validateAndReject2(id) {';
        echo '  var editReason = document.getElementById("editReasonTextarea").value;';
        echo '  var originalNote = "' . $note . '";'; // Add the original note as a JavaScript variable
        echo '  if (editReason.trim() === "") {';
        echo '    alert("Please provide a new reason for rejection.");';
        echo '    event.preventDefault();';
        echo '  } else if (editReason.trim() === originalNote) {';
        echo '    alert("The new reason cannot be the same as the previous reason.");';
        echo '    event.preventDefault();';
        echo '  } else {';
        echo '    editReasonRecord(id);'; // Call your existing function if the textarea is not empty and not the same as the original note
        echo '  }';
        echo '}';
        echo '</script>';
      }
      ?>

      <div class="submission-container">
        <div>
          <div style="margin-bottom: 16px;">
            <label for="NameInnov"> Name </label>
            <input type="text" name="NameInnov" placeholder="<?php echo $nameInnov ?>" disabled>
          </div>

          <div class="submission-item">
            <div>
              <div class="input-container">
                <label for="CreDate">Creation Date</label>
                <i class="bx bx-calendar-alt" style="color: rgb(170, 170, 170)"></i>
                <input id="creationdate" placeholder="<?php echo $creDate ?>" name="CreDate" disabled />
              </div>
            </div>

            <div>
              <label for="IDCateg"> Category </label>
              <select name="IDCateg" disabled>
                <option value="" disabled selected hidden><?php echo $nameCateg ?></option>
                <option value="1"> Thesis</option>
                <option value="2"> Internship</option>
                <option value="3"> Others</option>
              </select>
            </div>
          </div>

          <div class="submission-item">
            <div>
              <label for="IDType">Type</label>
              <select name="IDType" disabled>
                <option value="" disabled selected hidden><?php echo $nameType ?></option>
                <option value="1"> Website</option>
                <option value="2"> Desktop App</option>
                <option value="3"> Mobile App</option>
                <option value="4"> Others</option>
              </select>
            </div>
            <div>
              <label for="IDConc"> Concentration </label>
              <select name="IDConc" disabled>
                <option value="" disabled selected hidden><?php echo $nameConc ?></option>
                <option value="1"> Cybersecurity</option>
                <option value="2"> Management Information System</option>
                <option value="3"> Engineering and Business Intelligence</option>
                <option value="4"> Others</option>
              </select>
            </div>
          </div>

          <div class="submission-item">
            <div>
              <div class="input-container">
                <label for="Link">Innovation Link</label>
                <i class='bx bx-link' style="color: rgb(170, 170, 170)"></i>
                <input type="url" name="Link" placeholder="<?php echo $link ?>" disabled>
              </div>
            </div>
            <div>
              <div class="input-container">
                <label for="LinkYT">YouTube Link (Optional)</label>
                <i class='bx bx-link' style="color: rgb(170, 170, 170)"></i>
                <input type="url" name="LinkYT" placeholder="<?php
                                                              if (is_null($linkyoutube)) {
                                                                echo 'No link submitted';
                                                              } else {
                                                                echo $linkyoutube;
                                                              }
                                                              ?>" disabled>
              </div>
            </div>
          </div>

          <div class="field_wrapper">
            <div>
              <label for="user">Creators</label>
              <?php
              foreach ($creatorsResults as $IDUser => $creatorData) {
                $IDUser = $creatorData['IDUser'];
                $username = $creatorData['username'];

                echo '<div class="user-input">';
                echo '<select class="js-placeholder js-states form-control" name="IDUser[]" disabled>';
                echo '<option>(' . $IDUser . ') ' . $username . ' </option>';
                echo '</select>';
                echo '</div>';
              }
              ?>
            </div>
          </div>
        </div>

        <div>
          <label for="Description">Description </label>
          <textarea name="Description" placeholder="<?php echo $description ?>" disabled></textarea>
        </div>

      </div>

      <label for="Images">Images</label>
      <div style="pointer-events:none;" class="input-images">
        <div class="input-images-1" style="padding-top: .5rem;"></div>
      </div>

      <?php if ($_SESSION['role'] == 'admin' && $status == 'Pending') {
        echo '<div class="section-head" style="gap: 20px">';
        echo '<input type="submit" value="Approve" class="submit" onclick="approveRecord(' . $id . ')">';
        echo '<button class="submit red modal-button" href="#myModal1" type="button">Reject</button>';
        echo '</div>';

        // First time giving reason of rejection
        echo '<div id="myModal1" class="modal">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h4><label for="Reason">Input reason of rejection</label></h4>';
        echo '<div class="close close_multi"><i class=\'bx bx-x\' style="line-height: 0.8"></i></div>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<textarea id="reasonTextarea" name="Reason" placeholder="Be as clear as possible."></textarea>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<input type="submit" name="rejectButton" value="Reject" class="submit red" style="margin-top: 0; padding-top: 12px; padding-bottom: 12px;" onclick="validateAndReject(' . $id . ')">';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        echo '<script>';
        echo 'function validateAndReject(id) {';
        echo '  var reason = document.getElementById("reasonTextarea").value;';
        echo '  if (reason.trim() === "") {';
        echo '    alert("Please provide a reason for rejection.");';
        echo '    event.preventDefault();';
        echo '  } else {';
        echo '    rejectRecord(id);'; // Call your existing function if the textarea is not empty
        echo '  }';
        echo '}';
        echo '</script>';
      }
      ?>



    </form>
  </div>

  <?php include "footer.php" ?>

  <script>
    // Get the button that opens the modal
    var btn = document.querySelectorAll(".modal-button");

    // All page modals
    var modals = document.querySelectorAll(".modal");

    // Get the <span> element that closes the modal
    var spans = document.getElementsByClassName("close");

    // When the user clicks the button, open the modal
    for (var i = 0; i < btn.length; i++) {
      btn[i].onclick = function(e) {
        e.preventDefault();
        modal = document.querySelector(e.target.getAttribute("href"));
        modal.style.display = "block";
      };
    }

    // When the user clicks on <span> (x), close the modal
    for (var i = 0; i < spans.length; i++) {
      spans[i].onclick = function() {
        for (var index in modals) {
          if (typeof modals[index].style !== "undefined")
            modals[index].style.display = "none";
        }
      };
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target.classList.contains("modal")) {
        for (var index in modals) {
          if (typeof modals[index].style !== "undefined")
            modals[index].style.display = "none";
        }
      }
    };
  </script>

  <script>
    function rejectRecord(recordId) {
      var reason = $("textarea[name='Reason']").val();
      $.ajax({
        type: 'POST',
        url: '',
        data: {
          rejectButton: true,
          recordId: recordId,
          Reason: reason
        },
        success: function(response) {
          alert('This innovation has been rejected succesfully.');
          window.location.href = 'detail.php?id=<?= $id ?>';
        }
      });
    }

    function editReasonRecord(recordId) {
      var reason = $("textarea[name='Reason']").val();
      $.ajax({
        type: 'POST',
        url: '',
        data: {
          editReasonButton: true,
          recordId: recordId,
          Reason: reason
        },
        success: function(response) {
          alert('The reason of rejection has been edited succesfully.');
          window.location.href = 'detail.php?id=<?= $id ?>';
        }
      });
    }

    function approveRecord(recordId) {
      var confirmation = confirm("Are you sure you want to approve this innovation?");
      if (confirmation) {
        $.ajax({
          type: 'POST',
          url: '',
          data: {
            approveButton: true,
            recordId: recordId
          },
          success: function(response) {
            alert('This innovation has been approved succesfully.');
            window.location.href = 'innovation.php?id=<?= $id ?>';
          }
        });
      } else {
        event.preventDefault();
        alert('Approval process cancelled.');
      }
    }

    function deleteRecord(recordId) {
      var confirmation = confirm("Are you sure you want to delete this innovation?");
      if (confirmation) {
        $.ajax({
          type: 'POST',
          url: '',
          data: {
            deleteButton: true,
            recordId: recordId
          },
          success: function(response) {
            alert('This innovation has been deleted succesfully.');
            window.location.href = 'admin.php';
          }
        });
      } else {
        event.preventDefault();
        alert('Deletion process cancelled.');
      }
    }
  </script>

  <script>
    const picker1 = new easepick.create({
      element: "#creationdate",
      css: [
        'https://cdn.jsdelivr.net/npm/@easepick/core@1.2.1/dist/index.css',
        'easepick.css',
      ],
      zIndex: 9999999,
      AmpPlugin: {
        dropdown: {
          months: true,
          years: true
        }
      },
      plugins: ['AmpPlugin']
    });
  </script>

  <script>
    const picker2 = new easepick.create({
      element: "#submissiondate",
      css: [
        'https://cdn.jsdelivr.net/npm/@easepick/core@1.2.1/dist/index.css',
        'easepick.css',
      ],
      zIndex: 9999999,
      AmpPlugin: {
        dropdown: {
          months: true,
          years: true
        }
      },
      plugins: ['AmpPlugin']
    });
  </script>

  <script>
    let dynamicImages = <?php echo json_encode(array_values(array_filter($images))); ?>;

    let preloaded = dynamicImages.map(function(image, index) {
      return {
        id: index + 1,
        src: 'image/' + image
      };
    });

    $(function() {
      $('.input-images-1').imageUploader({
        preloaded: preloaded,
        imagesInputName: 'Img',
        maxSize: 2 * 1024 * 1024,
        maxFiles: 6
      });
    });
  </script>
  <script src="https://christianbayer.github.io/image-uploader/dist/image-uploader.min.js" type="text/javascript"></script>

</body>

</html>