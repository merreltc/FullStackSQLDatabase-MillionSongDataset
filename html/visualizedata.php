<?php
  // require 'import.php'
  // include("fusioncharts.php");
$sql = $_GET['sql_label'];
$extra = intval($_GET['extra']);

$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"projecttest");

switch ($sql) {
  case 'genre-perc-song':
  $sql="SELECT DISTINCT genre, COUNT(*) as genre_count FROM Song WHERE genre IS NOT NULL GROUP BY genre";
  $result = mysqli_query($con,$sql);

    //initialize the array to store the processed data
  $arrData = array();

    // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["genre"],
      "value" => $row["genre_count"]
      ));
  }
  break;

  case 'genre-perc-artist':
  $sql="SELECT DISTINCT genre, COUNT(*) as genre_count FROM Song s, Artist a WHERE genre IS NOT NULL AND s.artist = a.echonest_id GROUP BY genre";
  $result = mysqli_query($con,$sql);

    //initialize the array to store the processed data
  $arrData = array();

    // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["genre"],
      "value" => $row["genre_count"]
      ));
  }
  break;

  case "perc-year-genre-song":
  $sql="SELECT DISTINCT genre, COUNT(*) as genre_count FROM Song WHERE genre IS NOT NULL AND release_year = '".$extra."' GROUP BY genre";
  $result = mysqli_query($con,$sql);

    //initialize the array to store the processed data
  $arrData = array();

    // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["genre"],
      "value" => $row["genre_count"]
      ));
  }
  break;

  case "perc-year-genre-artist":
  $sql="SELECT DISTINCT genre, COUNT(*) as genre_count FROM Song s, Artist a WHERE genre IS NOT NULL AND s.artist = a.echonest_id AND s.release_year = '".$extra."' GROUP BY genre";
  $result = mysqli_query($con,$sql);

    //initialize the array to store the processed data
  $arrData = array();

    // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["genre"],
      "value" => $row["genre_count"]
      ));
  }

  break;

    case "ot-loudness":
  $sql="SELECT release_year, AVG(loudness) as avg_loudness FROM Song WHERE release_year <> 0 GROUP BY release_year";
  $result = mysqli_query($con,$sql);

    //initialize the array to store the processed data
  $arrData = array();

    // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["release_year"],
      "value" => $row["avg_loudness"]
      ));
  }

  break;

    case "ot-genre-pop":
  $sql="SELECT release_year, AVG(hotttnesss) FROM Song WHERE release_year <> 0 AND genre = 'Pop_Rock' GROUP BY release_year";
  $result = mysqli_query($con,$sql);

    //initialize the array to store the processed data
  $arrData = array();

    // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["release_year"],
      "value" => $row["hotttnesss"]
      ));
  }

  break;

    case "ot-track-count":
   $sql="SELECT release_year, COUNT(*) AS year_count FROM Song WHERE release_year <> 0 GROUP BY release_year";
  $result = mysqli_query($con,$sql);

    //initialize the array to store the processed data
  $arrData = array();

    // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["release_year"],
      "value" => $row["year_count"]
      ));
  }

  break;

  default:
  $sql="SELECT release_year, COUNT(*) AS year_count FROM Song WHERE release_year <> 0 GROUP BY release_year";
  $result = mysqli_query($con,$sql);

    //initialize the array to store the processed data
  $arrData = array();

    // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["release_year"],
      "value" => $row["year_count"]
      ));
  }
  break;
}
  // $jsonEncodedData = json_encode($arrData);
mysqli_close($con);

  //set the response content type as JSON
header('Content-type: application/json');
  //output the return value of json encode using the echo function. 
echo json_encode($arrData);
?>
