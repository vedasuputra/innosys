<?php

include "header.php";
include "connect.php";
// error_reporting(0);

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

if (isset($_POST['submit'])) {
  $NameInnov = $_POST['NameInnov'];
  $Description = $_POST['Description'];
  $CreDate = $_POST['CreDate'];
  $Link = $_POST['Link'];
  $LinkYT = $_POST['LinkYT'];
  $IDConc = $_POST['IDConc'];
  $IDCateg = $_POST['IDCateg'];
  $IDType = $_POST['IDType'];
  $id_user_array = $_POST['IDUser'];

  $ImgArray = [];
  if (is_array($_FILES['Img']['name'])) {
    $totalFiles = count($_FILES['Img']['name']);

    for ($i = 0; $i < $totalFiles; $i++) {
      $Img = $_FILES['Img']['name'][$i];
      $location = "image/" . $Img;
      move_uploaded_file($_FILES['Img']['tmp_name'][$i], $location);
      $ImgArray[] = $Img;
    }
    $ImgString = implode(",", $ImgArray);
  } else {
    $Img = $_FILES['Img']['name'];
    $location = "image/" . $Img;
    move_uploaded_file($_FILES['Img']['tmp_name'], $location);
    $ImgString = $Img;
  }

  $query = "INSERT INTO innovdata (NameInnov, Description, Status, SubmDate, CreDate, Link, Img, LinkYoutube, IDConc, IDCateg, IDType) VALUES
     ('$NameInnov','$Description','Pending', CURDATE(), '$CreDate','$Link', '$ImgString', '$LinkYT', '$IDConc', '$IDCateg', '$IDType')"; // Fix column name here

  if (mysqli_query($koneksi, $query)) {
    $IDInnov = mysqli_insert_id($koneksi);

    foreach ($id_user_array as $IDUser) {
      $query_user = "INSERT INTO userinnov (IDInnov, IDUser) VALUES ('$IDInnov', '$IDUser')";

      if (!mysqli_query($koneksi, $query_user)) {
        echo "error:" . $query_user . "<br>" . mysqli_error($koneksi);
      }
    }
    echo "<script>alert('Your form has been submitted.'); </script>";
  } else {
    echo "<script>alert('Error. Please try again or contact the admin.'); </script>";
  }
}
?>

<html>

<head>
  <title>Submission Form | SIFORS Innovation System</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="select2.css">
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="submission.css">
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
      <h1 class="headline-title">Submit Your Innovation</h1>
      <p>Your submission will be reviewed for approval once it is submitted, so make sure that you’ve written your
        submission carefully.</p>
    </div>
  </div>

  <div class="container">
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="section-title" style="margin-bottom: 20px;">Submission Form</div>
      <div class="submission-container">
        <div>
          <div style="margin-bottom: 16px;">
            <label for="NameInnov"> Name </label>
            <input type="text" name="NameInnov" placeholder="Input the innovation name..." required>
          </div>

          <div class="submission-item">
            <div>
              <div class="input-container">
                <label for="CreDate">Creation Date</label>
                <i class="bx bx-calendar-alt"></i>
                <input id="creationdate" placeholder="Insert date here..." name="CreDate" required />
              </div>
            </div>

            <div>
              <label for="IDCateg"> Category </label>
              <select name="IDCateg" required>
                <option value="" disabled selected hidden>Select a category...</option>
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
                <option value="" disabled selected hidden>Select a type...</option>
                <option value="1"> Website</option>
                <option value="2"> Desktop App</option>
                <option value="3"> Mobile App</option>
                <option value="4"> Others</option>
              </select>
            </div>
            <div>
              <label for="IDConc"> Concentration </label>
              <select name="IDConc" required>
                <option value="" disabled selected hidden>Select a concentration...</option>
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
                <input type="url" name="Link" placeholder="https://" required>
              </div>
            </div>
            <div>
              <div class="input-container">
                <label for="LinkYT">YouTube Link (Optional)</label>
                <i class='bx bx-link'></i>
                <input type="url" name="LinkYT" placeholder="https://">
              </div>
            </div>
          </div>

          <div class="field_wrapper">
            <div>
              <label for="user">Creators</label>
              <div class="user-input">
                <select class="js-placeholder js-states form-control" name="IDUser[]" required>
                  <option></option>
                  <optgroup label="Lecturers">
                    <?php
                    foreach ($lecturerresult as $row) {
                      echo '<option value="' . $row["IDUser"] . '">(' . $row["IDUser"] . ') ' . $row["Username"] . ' </option>';
                    }
                    ?>
                  </optgroup>
                  <optgroup label="Students">
                    <?php
                    foreach ($studentresult as $row) {
                      echo '<option value="' . $row["IDUser"] . '">(' . $row["IDUser"] . ') ' . $row["Username"] . ' </option>';
                    }
                    ?>
                  </optgroup>
                </select>

                <a href="javascript:void(0);" class="add_button" title="Add field"><i class='bx bx-plus'></i></a>
              </div>
            </div>
          </div>
        </div>

        <div>
          <label for="Description">Description </label>
          <textarea name="Description" placeholder="Add description here..." required></textarea>
        </div>

      </div>

      <label for="Images">Images</label>
      <div class="input-images">
        <div class="input-images-1" style="padding-top: .5rem;"></div>
      </div>

      <input type="submit" value="Submit" class="submit" name="submit">
    </form>
  </div>

  <?php include "footer.php"?>

  <script>
    $(".js-placeholder").select2({
      placeholder: "Input the creator's data...",
    });

    $(document).ready(function () {
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
      $(addButton).click(function () {
        x++; //Increase field counter
        $(wrapper).append(fieldHTML); //Add field html
        $(".js-placeholder").select2({
          placeholder: "Input the creator's data...",
        });
      });

      // Once remove button is clicked
      $(wrapper).on('click', '.remove_button', function (e) {
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
    $(function () {
      $('.input-images-1').imageUploader({
        imagesInputName: 'Img',
        label: 'Upload up to 6 images (Max 2MB per image)',
        maxSize: 2 * 1024 * 1024,
        maxFiles: 6
      });
    });
  </script>
  <script src="https://christianbayer.github.io/image-uploader/dist/image-uploader.min.js"
    type="text/javascript"></script>

</body>

</html>

<!-- <input type="text" name="IDUser[]" minlength="10" value="" placeholder="Insert 10-character ID..." maxlength="10"
                  required /> -->