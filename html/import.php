<!DOCTYPE html>
<html>
<head>
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

	echo "</table>";
 	mysqli_close($con);
 ?>
</body>
</html>
