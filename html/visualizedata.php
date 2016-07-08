<?php
  // require 'import.php'
  include("fusioncharts.php");
  $q = intval($_GET['q']);

  $con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
  if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
  }

  mysqli_select_db($con,"testdb");
  $sql="SELECT gender, COUNT(*) AS gender_count FROM test_table GROUP BY gender";
  $result = mysqli_query($con,$sql);

  //initialize the array to store the processed data
  $arrData = array();

  // iterating over each data and pushing it into $arrData array
  while ($row = mysqli_fetch_array($result)) {
    array_push($arrData, array(
      "label" => $row["gender"],
      "value" => $row["gender_count"]
      ));
  }

  // $jsonEncodedData = json_encode($arrData);
  mysqli_close($con);

  //set the response content type as JSON
  header('Content-type: application/json');
  //output the return value of json encode using the echo function. 
  echo json_encode($arrData);
?>
