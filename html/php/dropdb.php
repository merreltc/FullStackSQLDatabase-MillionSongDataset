<?php

$con = mysqli_connect('localhost','root','10826294');
 	if (!$con) {
 		die('Could not connect: ' . mysqli_error($con) . "\n");
 	}

 	// Make MillionSongs the current database		
	$db_selected = mysqli_select_db($con, 'projecttest');
	if (!$db_selected) {
		die('Database not connected');
	}

// To DROP Database
	$sql = "DROP DATABASE projecttest";

	if (mysqli_query($con, $sql)) {
	    echo "Database deleted successfully\n";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($con);
	}
?>
