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
	
	//sql to define types
	$sql = "GO
	--Creates rules for types
	CREATE RULE valid_index AS
		@index > 0 AND @index < 1;
	GO
	--Creates types for the database
	CREATE TYPE enID FROM char(18);
	CREATE TYPE mbID FROM uniqueidentifier;
	CREATE TYPE [7dID] FROM int;
	CREATE TYPE [index] FROM decimal;
	EXEC sp_bindrule valid_index, 'index';"
	
	if (mysqli_query($con, $sql)) {
		echo "Types defined successfully"
	} else {
		echo "Error defining types: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Song(
	echonest_id enID PRIMARY KEY, musicbrainz_id mbID UNIQUE, sevendigital_id [7dID] UNIQUE, 
	title varchar(100), [year] int,  release varchar(200), loudness decimal, hotttnesss [index],
	tempo float, [key] int, mode int, start decimal,
	CONSTRAINT valid_year CHECK([year] < YEAR(GETDATE()) AND [year] > 1800));";

	if (mysqli_query($con, $sql)) {
	    echo "Table Song created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Artist (
	echonest_id enID PRIMARY KEY, musicbrainz_id mbID UNIQUE, 
	name varchar(200), hotttnesss [index], familiarity [index]);";

	if (mysqli_query($con, $sql)) {
	    echo "Table Artist created successfully";
	} else {
	    echo "Error creating table: " . mysqli_error($con);
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS Performance (
	artist enID REFERENCES Artist(echonest_id), 
	song enID REFERENCES Song(echonest_id),
	genre varchar(200), PRIMARY KEY(artist, song));
	)";

	if (mysqli_query($con, $sql)) {
	    echo "Table Performance created successfully";
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
