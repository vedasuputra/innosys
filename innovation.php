<?php

include "connect.php";
include "loginfix.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("Error not found.");
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
    die("Error not found.");
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
    <title>Sistem Informasi Manajemen Sampah Terpadu Milik Kita | SIFORS Innovation System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="innovation.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/3a38bd7be5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <nav>
        <div class="navbar-start">
            <div style="padding-right: 13px">
                <a href="home.html">
                    <img src="photos\favicon.png" width="43px" height="43px" />
                </a>
            </div>
            <div class="title">
                <a href="home.html">Innovation System</a>
            </div>
        </div>
        <div class="navbar-end">
            <div style="padding-right: 34px">
                <a class="navlinks" href="home.html">Homepage</a>
                <a class="navlinks" href="catalogue.html">Catalogue</a>
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
                            <form action="">
                                <input type="search" placeholder="Click here to search..." />
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
                        <a class="droplinks" href="submit.html">Submit</a>
                        <a class="droplinks" href="help.html">Help</a>
                        <a class="droplinks" href="logout.php">Logout</a>
                    </div>
                <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                    <i id="userIcon" class="bx bx-shield profilebtn" onclick="profileFunction()" style="font-size: 25px; padding-top: 0.3rem"></i>
                    <div id="profileDropdown" class="user-dropdown">
                        <a class="droplinks" href="user.html">Dashboard</a>
                        <a class="droplinks" href="logout.php">Logout</a>
                    </div>
                <?php else : ?>
                    <a href="login.php"><i id="userIcon" class="bx bx-log-in-circle" style="font-size: 26px; padding-top: 0.3rem"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="navpadding"></div>

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
                    echo '<div class="demo-border"><img class="demo" src="http://img.youtube.com/vi/' .$linkyoutube['videoId']. '/mqdefault.jpg" onclick="currentSlide(1)"></div>';
                }
                foreach ($images as $i => $image) {
                    $slideNumber = $i + 2;
                    // Check if the image filename is not empty before attempting to display it
                    if (!empty($image)) {
                        echo '<div class="demo-border"><img class="demo" src="image/' . $image . '" onclick="currentSlide('. $slideNumber .')"></div>';
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
                <div onclick="javascript:location.href='#'" class="filter-button"><?php echo $category?></div>
            </div>
            <div>
                <h4>Concentration</h4>
                <div onclick="javascript:location.href='#'" class="filter-button"><?php echo $conc?></div>
            </div>
            <div>
                <h4>Type</h4>
                <div onclick="javascript:location.href='#'" class="filter-button"><?php echo $type?></div>
            </div>
            <div>
                <h4>Link</h4>
                <div class="innovation-link" onclick="javascript:location.href='<?php echo $link?>'">
                    <div>
                        <i class='bx bx-link' style="font-size: 70px;"></i>
                    </div>
                    <div>
                        <strong><?php echo $nameInnov?></strong>
                        <a href="<?php echo $link?>"><?php echo $link?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <footer>
        <div>
            <h3>Innovation System</h3>
            © Universitas Pendidikan Ganesha<br>
            Copyright 2023. All Rights Reserved
        </div>
        <div>
            <h4>Pages</h4>
            <a href="#">Dashboard</a>
            <a href="#">Catalogue</a>
        </div>
        <div>
            <h4>Others</h4>
            <a href="#">Help</a>
            <a href="#">Submit</a>
        </div>
    </footer>

    <script>
        $(".icon-search").on("click", function() {
            $(".search-form").fadeToggle();
        });

        $(".search-close").on("click", function() {
            $(".search-form").fadeToggle();
        });
    </script>

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

    <script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function profileFunction() {
            document.getElementById("profileDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.profilebtn')) {
                var dropdowns = document.getElementsByClassName("user-dropdown");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>

</body>

</html>