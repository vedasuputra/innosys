<?php

include "header.php";
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

if ($_SESSION['role'] !== 'user') {
  echo "<script>
          alert('Error: You must be logged in as a user to access this page.');
          window.history.back();
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

$previousSubmission = "SELECT innovdata.IDInnov, innovdata.NameInnov, innovdata.Description, innovdata.Status, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, innovdata.Link, innovdata.LinkYouTube, innovdata.IDConc, innovdata.IDCateg, innovdata.IDType, category.NameCateg, concentration.NameConc, type.NameType, userinnov.IDUser, user.Username
          FROM innovdata 
          JOIN type ON innovdata.IDType = type.IDType 
          JOIN concentration ON innovdata.IDConc = concentration.IDConc 
          JOIN category ON innovdata.IDCateg = category.IDCateg 
          JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
          JOIN user ON userinnov.IDUser = user.IDUser
          WHERE innovdata.IDInnov='$id'
          ORDER BY `innovdata`.`creDate` DESC";

$previousResult = mysqli_query($koneksi, $previousSubmission);
$previousRow = mysqli_fetch_assoc($previousResult);

// Your existing code for processing the row goes here
$PreviousIDInnov = $previousRow['IDInnov'];
$PreviousnameInnov = $previousRow['NameInnov'];
$Previousdescription = $previousRow['Description'];
$Previousstatus = $previousRow['Status'];
$Previouslink = $previousRow['Link'];
$Previouslinkyoutube = $previousRow['LinkYouTube'];
$PreviousIDCateg = $previousRow['IDCateg'];
$PreviousnameCateg = $previousRow['NameCateg'];
$PreviousIDType = $previousRow['IDType'];
$PreviousnameType = $previousRow['NameType'];
$PreviousIDConc = $previousRow['IDConc'];
$PreviousnameConc = $previousRow['NameConc'];
$PreviouscreDate = date("Y-m-d", strtotime($previousRow['CreDate']));
$PreviousSubmDate = date("Y-m-d", strtotime($previousRow['SubmDate']));
$Previousimages = explode(",", $previousRow['Img']);
$Previoususername = $previousRow['Username'];
$Previousid_user_array = array($previousRow['IDUser']);

if (!$previousRow) {
  echo "<script>
          alert('Error: Innovation with this ID can\'t be found.');
          window.history.back();
        </script>";
  exit();
}

if ($Previousstatus == 'Approved') {
  echo "<script>
          alert('Error: Innovation with this ID has been approved by the admin. Go to the approved innovation page?');
          window.location.href = 'innovation.php?id=' + $id;
        </script>";
  exit();
}

if ($Previousstatus == 'Pending') {
  echo "<script>
          alert('Error: You can\'t edit a submission that has not been validated by the admin.');
          window.history.back();
        </script>";
  exit();
}

$creatorsQuery = "SELECT userinnov.IDUser, user.Username 
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

if ($Previousstatus == 'Rejected') {
  $rejectedQuery = "SELECT validation.Note 
                  FROM innovdata 
                  JOIN validation ON innovdata.IDInnov = validation.IDInnov
                  WHERE innovdata.IDInnov='$id' AND innovdata.Status = 'Rejected'";

  $rejectedResult = mysqli_query($koneksi, $rejectedQuery);
  $rejectedRow = mysqli_fetch_assoc($rejectedResult);

  $note = $rejectedRow['Note'];
}

$lecturer = "
    SELECT IDUser, Username FROM user 
    WHERE Role = 'Lecturer'
    ORDER BY IDUser ASC
";

$lecturerresult = $koneksi->query($lecturer);

$student = "
    SELECT IDUser, Username FROM user 
    WHERE Role = 'Student'
    ORDER BY IDUser ASC
";

$studentresult = $koneksi->query($student);

if (isset($_POST['submitForm'])) {
  $NameInnov = $_POST['NameInnov'];
  $Description = $_POST['Description'];
  $CreDate = $_POST['CreDate'];
  $Link = $_POST['Link'];
  $LinkYT = isset($_POST['LinkYT']) && !empty($_POST['LinkYT']) ? $_POST['LinkYT'] : NULL;
  $IDConc = $_POST['IDConc'];
  $IDCateg = $_POST['IDCateg'];
  $IDType = $_POST['IDType'];
  $id_user_array = $_POST['IDUser'];

  if (
    $NameInnov == $PreviousnameInnov &&
    $Description == $Previousdescription &&
    $CreDate == $PreviouscreDate &&
    $Link == $Previouslink &&
    $LinkYT == $Previouslinkyoutube &&
    $IDConc == $PreviousIDConc &&
    $IDCateg == $PreviousIDCateg &&
    $IDType == $PreviousIDType &&
    $id_user_array == $Previousid_user_array
  ) {
    echo "<script>
            alert('Error: No changes have been made. Please make changes before submitting.');
            window.location.href = 'edit.php?id=' + $id;
          </script>";
    exit();
  }

  // Update the database with the merged images
  $query = "UPDATE innovdata SET 
          NameInnov='$NameInnov',
          Description='$Description',
          Status='Pending',
          SubmDate=CURDATE(),
          CreDate='$CreDate',
          Link='$Link',
          LinkYoutube=" . ($LinkYT !== NULL ? "'$LinkYT'" : "NULL") . ",
          IDConc='$IDConc',
          IDCateg='$IDCateg',
          IDType='$IDType'
          WHERE IDInnov='$id'";

  if (mysqli_query($koneksi, $query)) {

    // Remove the existing userinnov entries for this innovation
    $deleteUserQuery = "DELETE FROM userinnov WHERE IDInnov='$id'";
    mysqli_query($koneksi, $deleteUserQuery);

    // Remove the existing validation entries for this innovation
    $deleteValidationQuery = "DELETE FROM validation WHERE IDInnov='$id'";
    mysqli_query($koneksi, $deleteValidationQuery);

    // Insert new userinnov entries for this innovation
    foreach ($id_user_array as $IDUser) {
      $query_user = "INSERT INTO userinnov (IDInnov, IDUser) VALUES ('$id', '$IDUser')";

      if (!mysqli_query($koneksi, $query_user)) {
        echo "error:" . $query_user . "<br>" . mysqli_error($koneksi);
      }
    }

    echo "<script>
            alert('Your submission has been edited and is now eligible to be reviewed again by the admin.'); 
            window.location.href = 'detail.php?id=' + $id;
          </script>";
  } else {
    echo "<script>alert('Error. Please try again or contact the admin.'); </script>";
  }
}
?>

<html>

<head>
  <title>Edit Submitted Form | SIFORS Innovation System</title>
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

<style>
  select:invalid {
    color: #041f35;
  }
</style>

<body>
  <div class="headline submission">
    <div class="headline-content">
      <h1 class="headline-title">Submit Your Innovation</h1>
      <p>Your submission will be reviewed for approval once it is submitted, so make sure that you’ve written your
        submission carefully.</p>
    </div>
  </div>

  <div class="container">
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="section-title" style="margin-bottom: 20px;">Submission Form</div>

      <?php
      echo '<div class="creators-info danger" style="margin-bottom: 15px">';
      echo '<div>Submission has been rejected because "' . $note . '" </div>';
      echo '<div><span class="status right ' . $Previousstatus . '">' . $Previousstatus . '</span></div>';
      echo '</div>';
      ?>

      <div class="creators-info info">
        <div>You are not allowed to edit the images you have submitted. If you want to edit your images, please <strong><a href="submission.php">resubmit your submission.</a></strong></div>
        <div><i class='bx bxs-error-circle right' style="font-size: 22px; line-height: 1;"></i></div>
      </div>

      <div class="submission-container">
        <div>
          <div style="margin-bottom: 16px;">
            <label for="NameInnov"> Name </label>
            <input type="text" name="NameInnov" placeholder="Input the innovation name..." value="<?php echo $PreviousnameInnov ?>" required>
          </div>

          <div class="submission-item">
            <div>
              <div class="input-container">
                <label for="CreDate">Creation Date</label>
                <i class="bx bx-calendar-alt"></i>
                <input id="creationdate" placeholder="Insert date here..." name="CreDate" value="<?php echo $PreviouscreDate ?>" required />
              </div>
            </div>

            <div>
              <label for="IDCateg"> Category </label>
              <select name="IDCateg" required>
                <option value="<?php echo $PreviousIDCateg ?>" selected hidden><?php echo $PreviousnameCateg ?></option>
                <option value="1"> Thesis</option>
                <option value="2"> Internship</option>
                <option value="3"> Others</option>
              </select>
            </div>
          </div>

          <div class="submission-item">
            <div>
              <label for="IDType">Type</label>
              <select name="IDType" required>
                <option value="<?php echo $PreviousIDType ?>" selected hidden><?php echo $PreviousnameType ?></option>
                <option value="1"> Website</option>
                <option value="2"> Desktop App</option>
                <option value="3"> Mobile App</option>
                <option value="4"> Others</option>
              </select>
            </div>
            <div>
              <label for="IDConc"> Concentration </label>
              <select name="IDConc" required>
                <option value="<?php echo $PreviousIDConc ?>" selected hidden><?php echo $PreviousnameConc ?></option>
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
                <i class='bx bx-link'></i>
                <input type="url" name="Link" placeholder="https://" value="<?php echo $Previouslink ?>" required>
              </div>
            </div>
            <div>
              <div class="input-container">
                <label for="LinkYT">YouTube Link (Optional)</label>
                <i class='bx bx-link'></i>
                <input type="url" name="LinkYT" <?php
                                                if (is_null($Previouslinkyoutube)) {
                                                  echo 'placeholder="No link submitted"';
                                                } else {
                                                  echo 'value="' . $Previouslinkyoutube . '"';
                                                }
                                                ?>>
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
                echo '<select class="js-placeholder js-states form-control" name="IDUser[]">';
                echo '<option value="' . $IDUser . '">(' . $IDUser . ') ' . $username . ' </option>';

                echo '<optgroup label="Lecturers">';
                foreach ($lecturerresult as $row) {
                  echo '<option value="' . $row["IDUser"] . '">(' . $row["IDUser"] . ') ' . $row["Username"] . ' </option>';
                }

                echo '</optgroup>';

                echo '<optgroup label="Students">';
                foreach ($studentresult as $row) {
                  echo '<option value="' . $row["IDUser"] . '">(' . $row["IDUser"] . ') ' . $row["Username"] . ' </option>';
                }
                echo '</optgroup>';
                echo '</select>';
                if ($IDUser === array_key_first($creatorsResults)) {
                  echo '<a href="javascript:void(0);" class="add_button" title="Add field"><i class=\'bx bx-plus\'></i></a>';
                } else {
                  echo '<a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="bx bx-minus"></i></a>';
                }
                echo '</div>';
              }
              ?>
            </div>
          </div>
        </div>

        <div>
          <label for="Description">Description </label>
          <textarea name="Description" placeholder="Add description here..." required><?php echo $Previousdescription ?></textarea>
        </div>

      </div>

      <label for="Images">Images</label>
      <div style="pointer-events:none;" class="input-images">
        <div class="input-images-1" style="padding-top: .5rem;"></div>
      </div>

      <input type="submit" value="Edit" class="submit" name="submitForm" onClick="return confirmSubmission();">
    </form>
  </div>

  <?php include "footer.php" ?>

  <script>
    function confirmSubmission() {
      // Display a confirmation dialog
      var isConfirmed = confirm('Are you sure you want to edit the form? You will NOT be able to edit your submission unless the admin has rejected it.');

      if (!isConfirmed) {
        return false; // User clicked Cancel, do not submit the form
      }

      var selectedCreators = document.querySelectorAll('.js-placeholder');
      var selectedCreatorsArray = Array.from(selectedCreators).map(option => option.value);

      if (hasDuplicates(selectedCreatorsArray)) {
        alert('Please ensure that each creator is selected only once.');
        return false; // Prevent form submission
      }

      var selectedCreators = document.querySelectorAll('.js-placeholder');
      var selectedCreatorsArray = Array.from(selectedCreators).map(option => option.value);
      if (!selectedCreatorsArray.includes('<?php echo $loggedInUserID; ?>')) {
        alert('Please make sure you are one of the creators of the submission.');
        return false; // Prevent form submission
      }

      return true; // Allow form submission
    }
  </script>

  <script>
    $(".js-placeholder").select2({
      placeholder: "Input the creator's data...",
    });

    $(document).ready(function() {
      var maxField = 10; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      var fieldHTML = '<div class="user-input"><select class="js-placeholder js-states form-control" name="IDUser[]"><option></option><optgroup label="Lecturers"><?php foreach ($lecturerresult as $row) {
                                                                                                                                                                    echo '<option value="' . $row["IDUser"] . '">(' . $row["IDUser"] . ') ' . $row["Username"] . ' </option>';
                                                                                                                                                                  } ?></optgroup><optgroup label="Students"><?php foreach ($studentresult as $row) {
                                                                                                                                                                                                              echo '<option value="' . $row["IDUser"] . '">(' . $row["IDUser"] . ') ' . $row["Username"] . ' </option>';
                                                                                                                                                                                                            } ?></optgroup></select><a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="bx bx-minus"></i></a></div>'; //New input field html 
      var x = 1; //Initial field counter is 1

      // Once add button is clicked
      $(addButton).click(function() {
        x++; //Increase field counter
        $(wrapper).append(fieldHTML); //Add field html
        $(".js-placeholder").select2({
          placeholder: "Input the creator's data...",
        });
      });

      // Once remove button is clicked
      $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
      });
    });
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
    let dynamicImages = <?php echo json_encode(array_values(array_filter($Previousimages))); ?>;

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