<!DOCTYPE html>
<html>
<head>

<?php require 'import.php';?>

<?php
    //Including FusionCharts’ PHP Wrapper
    include("fusioncharts.php");
?>

<style>
table {
    width: 100%;
    border-collapse: collapse;
}

 table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>

<body>

<?php
	$q = intval($_GET['q']);

 	$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
 	if (!$con) {
  	   die('Could not connect: ' . mysqli_error($con));
 	}

 	mysqli_select_db($con,"projecttest");
 	$sql="SELECT * FROM projecttest";
 	$result = mysqli_query($con,$sql);

 	echo "<table>
 	<tr>
 	<th>ID</th>
 	<th>Echonest</th>
    <th>MusicBrainz</th>
    <th>Username</th>
 	</tr>";

 	while($row = mysqli_fetch_array($result)) {
    	echo "<tr>";
     	echo "<td>" . $row['master_id'] . "</td>";
     	echo "<td>" . $row['echonest_id'] . "</td>";
        echo "<td>" . $row['musicbrainz_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
     	echo "</tr>";
 	}

	echo "</table>";
 	mysqli_close($con);
 ?>

</body>
</html>
