<!DOCTYPE html>
<html>
<head>
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

 	$con = mysqli_connect('localhost','superuser','super_PASS123','testing');
 	if (!$con) {
  	   die('Could not connect: ' . mysqli_error($con));
 	}

 	mysqli_select_db($con,"testing");
 	$sql="SELECT * FROM tester WHERE id='".$q."'";
 	$result = mysqli_query($con,$sql);

 	echo "<table>
 	<tr>
 	<th>name</th>
 	<th>email</th>
 	</tr>";

 	while($row = mysqli_fetch_array($result)) {
    	echo "<tr>";
     	echo "<td>" . $row['name'] . "</td>";
     	echo "<td>" . $row['email'] . "</td>";
     	echo "</tr>";
 	}

	echo "</table>";
 	mysqli_close($con);
 ?>

</body>
</html>