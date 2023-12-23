<?php

include "connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "<script>
            alert('Error: An innovation ID is required.');
            window.history.back();
          </script>";
    exit();
}

$query = "SELECT innovdata.Status, innovdata.IDInnov, innovdata.NameInnov, innovdata.Description, innovdata.Img, innovdata.CreDate, innovdata.SubmDate, category.NameCateg, concentration.NameConc, type.NameType, userinnov.IDUser, user.Username, user.Role, user.Email, innovdata.Link, innovdata.LinkYoutube 
        FROM innovdata 
        JOIN type ON innovdata.IDType = type.IDType 
        JOIN concentration ON innovdata.IDConc = concentration.IDConc 
        JOIN category ON innovdata.IDCateg = category.IDCateg 
        JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
        JOIN user ON userinnov.IDUser = user.IDUser
        WHERE innovdata.IDInnov='$id'";

$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>
            alert('Error: Innovation with this ID can\'t be found.');
            window.history.back();
          </script>";
    exit();
}

$nameInnov = $row['NameInnov'];
$category = $row['NameCateg'];
$type = $row['NameType'];
$conc = $row['NameConc'];
$creDate = date("F j, Y", strtotime($row['CreDate']));
$SubmDate = date("F j, Y", strtotime($row['SubmDate']));
$description = $row['Description'];
$images = explode(",", $row['Img']);
$status = $row['Status'];
$link = $row['Link'];
$youtube = $row['LinkYoutube'];

if ($status !== 'Approved') {
    echo "<script>
            alert('Error: Innovation with this ID has not been approved by the admin.');
            window.history.back();
          </script>";
    exit();
}

function getYoutubeEmbedUrl($youtube)
{
    $result = array('embedUrl' => '', 'videoId' => '');

    // Extract video ID from YouTube URL
    if (strpos($youtube, 'youtube.com/') !== false) {
        // Youtube video
        $videoId = isset(explode("v=", $youtube)[1]) ? explode("v=", $youtube)[1] : null;
        if (strpos($videoId, '&') !== false) {
            $videoId = explode("&", $videoId)[0];
        }
        $result['embedUrl'] = 'https://www.youtube.com/embed/' . $videoId;
        $result['videoId'] = $videoId;
    } else if (strpos($youtube, 'youtu.be/') !== false) {
        // Youtube video
        $parts = explode("youtu.be/", $youtube);
        $videoId = isset($parts[1]) ? $parts[1] : null;

        // Remove query parameters from videoId
        if (strpos($videoId, '?') !== false) {
            $videoId = explode("?", $videoId)[0];
        }

        $result['embedUrl'] = 'https://www.youtube.com/embed/' . $videoId;
        $result['videoId'] = $videoId;
    }

    return $result;
}

$linkyoutube = getYoutubeEmbedUrl($youtube);

include "header.php";
?>

<?php

$creatorsQuery = "SELECT  userinnov.IDUser, user.Username, user.Role, user.Email 
FROM innovdata 
JOIN userinnov ON innovdata.IDInnov = userinnov.IDInnov
JOIN user ON userinnov.IDUser = user.IDUser
WHERE innovdata.IDInnov='$id'";

$creatorsResult = mysqli_query($koneksi, $creatorsQuery);
$creatorsResults = array();

while ($creatorsRow = mysqli_fetch_assoc($creatorsResult)) {
    $username = $creatorsRow['Username'];
    $IDUser = $creatorsRow['IDUser'];
    $role = $creatorsRow['Role'];
    $email = $creatorsRow['Email'];
    $creatorsResults[$IDUser] = array(
        'username' => $username,
        'role' => $role,
        'email' => $email
    );
}


?>

<html>

<head>
    <title><?php echo $nameInnov ?> | SIFORS Innovation System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="innovation.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="userdropdown.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="slideshow">
        <?php
        if (!empty($youtube)) {
            echo '<div class="mySlides"><iframe width="100%" height="565px" src="' . $linkyoutube['embedUrl'] . '?controls=0&rel=0&iv_load_policy=3&fs=0&controls=0&disablekb=1" frameborder="0" allow=""></iframe></div>';
        }
        if (!empty($images)) {
            // Iterate through the images for the current creator
            foreach ($images as $i => $image) {
                // Check if the image filename is not empty before attempting to display it
                if (!empty($image)) {
                    echo '<div class="mySlides"><img src="image/' . $image . '"></div>';
                }
            }
        }
        ?>

        <a class="prev" onclick="plusSlides(-1)"><i class='bx bx-chevron-left'></i></a>
        <a class="next" onclick="plusSlides(1)"><i class='bx bx-chevron-right'></i></a>

        <div class="row">
            <?php
            if (!empty($images)) {
                // Iterate through the images for the current creator
                if (!empty($youtube)) {
                    echo '<div class="demo-border"><img class="demo" src="http://img.youtube.com/vi/' . $linkyoutube['videoId'] . '/mqdefault.jpg" onclick="currentSlide(1)"></div>';
                }
                foreach ($images as $i => $image) {
                    $slideNumber = $i + 2;
                    // Check if the image filename is not empty before attempting to display it
                    if (!empty($image)) {
                        echo '<div class="demo-border"><img class="demo" src="image/' . $image . '" onclick="currentSlide(' . $slideNumber . ')"></div>';
                    }
                }
            }
            ?>
        </div>
    </div>

    <div class="container">
        <div class="innovation-container">
            <div class="innovation-main">
                <?php
                echo '<h1>' . $nameInnov . '</h1>';
                echo '<div class="creation-date">Created on ' . $creDate . '</div>';
                echo nl2br('<div class="innovation-text">' . $description . '</div>');
                echo '<div class="creators-header">';
                echo '<h4>Creators</h4>';
                echo '<span>People under the Information System study program</span>';
                echo '</div>';
                echo '<div class="innovation-creators">';
                ?>
                <?php
                $counter = 0;

                foreach ($creatorsResults as $IDUser => $creatorData) {
                    $username = $creatorData['username'];
                    $role = $creatorData['role'];
                    $email = $creatorData['email'];

                    if ($counter > 0 && $counter % 2 == 0) {
                        echo '</div>';
                        echo '<div class="innovation-creators">';
                    }

                    echo '<div class="creators-info" title="' . $username . '" onclick="javascript:location.href=\'#\'">';
                    echo '<div>';
                    echo '<div class="creator-name"><span class="status ' . $role . '">' . $role . '</span>' . $username . '</div>';
                    echo '<span class="creator-role">' . $email . '</span>';
                    echo '</div>';
                    echo '<div><i class=\'bx bx-chevron-right more-icon right\'></i></div>';
                    echo '</div>';

                    $counter++;
                };
                ?>
            </div>
        </div>

        <div class="innovation-right">
            <div>
                <h4>Category</h4>
                <div onclick="javascript:location.href='#'" class="filter-button"><?php echo $category ?></div>
            </div>
            <div>
                <h4>Concentration</h4>
                <div onclick="javascript:location.href='#'" class="filter-button"><?php echo $conc ?></div>
            </div>
            <div>
                <h4>Type</h4>
                <div onclick="javascript:location.href='#'" class="filter-button"><?php echo $type ?></div>
            </div>
            <div>
                <h4>Link</h4>
                <div class="innovation-link" onclick="javascript:location.href='<?php echo $link ?>'">
                    <div>
                        <i class='bx bx-link' style="font-size: 70px;"></i>
                    </div>
                    <div>
                        <strong><?php echo $nameInnov ?></strong>
                        <a href="<?php echo $link ?>"><?php echo $link ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php include "footer.php" ?>

    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("demo");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>

</body>

</html>