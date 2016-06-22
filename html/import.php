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

 	// Make MillionSongs the current database
	$db_selected = mysql_select_db($con, 'testdb');
	if (!$db_selected) {
		// Create database
		 $sql = "CREATE DATABASE testdb";
		if (mysqli_query($con, $sql)) {
		    echo "Database created successfully";
		} else {
		    echo "Error creating database: " . mysqli_error($con);
		}
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Song (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table MyGuests created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Artist (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table MyGuests created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Listener (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table MyGuests created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Performs (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table MyGuests created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Tag (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table MyGuests created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($conn);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Favorite_Songs (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table MyGuests created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Listens_To_Artist (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table MyGuests created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Listens_To_Song (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table MyGuests created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

 	mysqli_close($con);
 ?>
</body>
</html>
