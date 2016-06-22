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

 	$con = mysqli_connect('localhost','root','strawberry','test');
 	if (!$con) {
  	   die('Could not connect: ' . mysqli_error($con));
 	}

 	mysqli_select_db($con,"testdb");
 	$sql="SELECT * FROM test_table WHERE id='".$q."'";
 	$result = mysqli_query($con,$sql);

 	echo "<table>
 	<tr>
 	<th>Name</th>
 	<th>Gender</th>
    <th>Email</th>
 	</tr>";

 	while($row = mysqli_fetch_array($result)) {
    	echo "<tr>";
     	echo "<td>" . $row['name'] . "</td>";
     	echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
     	echo "</tr>";
 	}

	echo "</table>";
 	mysqli_close($con);
 ?>

</body>
</html>
