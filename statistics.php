<?php
$username = "root";
$password = "";
$database = "innosys";

try {
  $pdo = new PDO("mysql:host=localhost;database=$database", $username, $password);
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
  die("ERROR: Could not connect. " . $e->getMessage());
}

try{
  $category = "SELECT YEAR(innovdata.CreDate) AS categoryyear,
  SUM(CASE WHEN innovdata.IDCateg = '1' THEN 1 ELSE 0 END) AS count_thesis,
  SUM(CASE WHEN innovdata.IDCateg = '2' THEN 1 ELSE 0 END) AS count_internship,
  SUM(CASE WHEN innovdata.IDCateg = '3' THEN 1 ELSE 0 END) AS count_othercategory
  FROM `innosys`.`innovdata`
  WHERE innovdata.Status = 'Approved' 
  GROUP BY YEAR(innovdata.CreDate)
  ORDER BY categoryyear ASC;"; 
  $categoryResult = $pdo->query($category);
  if($categoryResult->rowCount() > 0) {
    $categoryyear = array();
    $count_thesis = array();
    $count_internship = array();
    $count_othercategory = array();
    while($row = $categoryResult->fetch()) {
      $categoryyear[] = $row["categoryyear"];
      $count_thesis[] = $row["count_thesis"];
      $count_internship[] = $row["count_internship"];
      $count_othercategory[] = $row["count_othercategory"];
    }

    unset($categoryResult);
  } else {
    echo "No records matching your query were found.";
  }
} catch(PDOException $e){
  die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

try{
  $type = "SELECT YEAR(innovdata.CreDate) AS typeyear,
  SUM(CASE WHEN innovdata.IDType = '1' THEN 1 ELSE 0 END) AS count_website,
  SUM(CASE WHEN innovdata.IDType = '2' THEN 1 ELSE 0 END) AS count_desktop,
  SUM(CASE WHEN innovdata.IDType = '3' THEN 1 ELSE 0 END) AS count_mobile,
  SUM(CASE WHEN innovdata.IDType = '4' THEN 1 ELSE 0 END) AS count_othertype
  FROM `innosys`.`innovdata`
  WHERE innovdata.Status = 'Approved' 
  GROUP BY YEAR(innovdata.CreDate)
  ORDER BY typeyear ASC;"; 
  $typeResult = $pdo->query($type);
  if($typeResult->rowCount() > 0) {
    $typeyear = array();
    $count_website = array();
    $count_desktop = array();
    $count_mobile = array();
    $count_othertype = array();
    while($row = $typeResult->fetch()) {
      $typeyear[] = $row["typeyear"];
      $count_website[] = $row["count_website"];
      $count_desktop[] = $row["count_desktop"];
      $count_mobile[] = $row["count_mobile"];
      $count_othertype[] = $row["count_othertype"];
    }

    unset($typeResult);
  } else {
    echo "No records matching your query were found.";
  }
} catch(PDOException $e){
  die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

try{
  $conc = "SELECT YEAR(innovdata.CreDate) AS concyear,
  SUM(CASE WHEN innovdata.IDConc = '1' THEN 1 ELSE 0 END) AS count_cyber,
  SUM(CASE WHEN innovdata.IDConc = '2' THEN 1 ELSE 0 END) AS count_msi,
  SUM(CASE WHEN innovdata.IDConc = '3' THEN 1 ELSE 0 END) AS count_rib,
  SUM(CASE WHEN innovdata.IDConc = '4' THEN 1 ELSE 0 END) AS count_otherconc
  FROM `innosys`.`innovdata`
  WHERE innovdata.Status = 'Approved' 
  GROUP BY YEAR(innovdata.CreDate)
  ORDER BY concyear ASC;"; 
  $concResult = $pdo->query($conc);
  if($concResult->rowCount() > 0) {
    $concyear = array();
    $count_cyber = array();
    $count_msi = array();
    $count_rib = array();
    $count_otherconc = array();
    while($row = $concResult->fetch()) {
      $concyear[] = $row["concyear"];
      $count_cyber[] = $row["count_cyber"];
      $count_msi[] = $row["count_msi"];
      $count_rib[] = $row["count_rib"];
      $count_otherconc[] = $row["count_otherconc"];
    }

    unset($concResult);
  } else {
    echo "No records matching your query were found.";
  }
} catch(PDOException $e){
  die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

// All count
$allCount = "SELECT COUNT(*) AS total FROM innovdata WHERE innovdata.Status = 'Approved'";
$allCountResult = mysqli_query($koneksi, $allCount);
$allCountRow = mysqli_fetch_assoc($allCountResult);
$allCountTotal = $allCountRow['total'];

// Category count
$categoryCount = "SELECT category.NameCateg, COUNT(*) as categoryCount 
                  FROM innovdata 
                  JOIN category ON innovdata.IDCateg = category.IDCateg 
                  WHERE innovdata.Status = 'Approved'
                  GROUP BY category.NameCateg
                  ORDER BY `category`.`IDCateg` ASC";
$categoryCountResult = mysqli_query($koneksi, $categoryCount);
$categoryCounts = array();

while ($row = mysqli_fetch_assoc($categoryCountResult)) {
  $categoryName = $row['NameCateg'];
  $categoryCountTotal = $row['categoryCount'];
  $categoryCounts[$categoryName] = $categoryCountTotal;
}

// Type count
$typeCount = "SELECT type.NameType, COUNT(*) as typeCount 
              FROM innovdata 
              JOIN type ON innovdata.IDType = type.IDType 
              WHERE innovdata.Status = 'Approved'
              GROUP BY type.NameType
              ORDER BY `type`.`IDType` ASC";
$typeCountResult = mysqli_query($koneksi, $typeCount);
$typeCounts = array();

while ($row = mysqli_fetch_assoc($typeCountResult)) {
  $typeName = $row['NameType'];
  $typeCountTotal = $row['typeCount'];
  $typeCounts[$typeName] = $typeCountTotal;
}

// Concentration count
$concentrationCount = "SELECT concentration.NameConc, COUNT(*) as concentrationCount 
                       FROM innovdata 
                       JOIN concentration ON innovdata.IDConc = concentration.IDConc 
                       WHERE innovdata.Status = 'Approved'
                       GROUP BY concentration.NameConc
                       ORDER BY `concentration`.`IDConc` ASC";
$concentrationCountResult = mysqli_query($koneksi, $concentrationCount);
$concentrationCounts = array();

while ($row = mysqli_fetch_assoc($concentrationCountResult)) {
  $concentrationName = $row['NameConc'];
  $concentrationCountTotal = $row['concentrationCount'];
  $concentrationCounts[$concentrationName] = $concentrationCountTotal;
}
 
// Close connection
unset($pdo);
?>


