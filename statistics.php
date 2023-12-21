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
 
// Close connection
unset($pdo);
?>

