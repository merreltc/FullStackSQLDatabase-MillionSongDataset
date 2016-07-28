<?php
$stat = $_GET['stat'];

$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,'projecttest');

switch($stat) {
  case "song-stat":
  $sql="SELECT COUNT(title) AS count FROM Song";
  break;

  case "artist-stat":
  $sql="SELECT COUNT(*) AS count FROM Artist";
  break;

  case "listener-stat":
  $sql="SELECT COUNT(*) AS count FROM Listener";
  break;

  case "song-tag-stat":
  $sql="SELECT COUNT(*) AS count FROM Tag";
  break;

  case "artist-tag-stat":
  $sql="SELECT COUNT(*) AS count FROM Artist_Tag";
  break;
}

$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
  echo "". $row['count'] ."";
}

mysqli_close($con);
?>