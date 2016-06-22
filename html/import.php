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
		// Create database and tables
		 $sql = "CREATE DATABASE testdb";
		if (mysqli_query($con, $sql)) {
		    echo "Database created successfully";
		} else {
		    echo "Error creating database: " . mysqli_error($con);
		}

		//sql to define types
		$sql = "GO
		--Creates rules and types for database;
	
		GO
		CREATE TYPE enID FROM char(18);
		CREATE TYPE mbID FROM uniqueidentifier;
		CREATE TYPE sevenDID FROM int;
		CREATE TYPE popularity_index FROM decimal;
		CREATE TYPE tag_type FROM varchar(10);
		CREATE RULE valid_index AS
			@poularity_index > 0 AND @popularity_index < 1;
		EXEC sp_bindrule valid_index, 'popularity_index'";
		
		if (mysqli_query($con, $sql)) {
			echo "Types defined successfully"
		} else {
			echo "Error defining types: " . mysqli_error($con);
		}

		// sql to create Song table
		$sql = "CREATE TABLE IF NOT EXISTS Song (
		echonest_id enID PRIMARY KEY,
		sevendigital_id [7dID] UNIQUE, 
		title varchar(100),
		release_year int, 
		release varchar(200),
		loudness decimal,
		hotttnesss popularity_index,
		tempo float,
		song_key int,
		mode int,
		start decimal,
		CONSTRAINT valid_year CHECK(release_year < YEAR(GETDATE())
			AND release_year > 1800));";

		if (mysqli_query($con, $sql)) {
		    echo "Table Song created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($con);
		}

		// sql to create Artist table
		$sql = "CREATE TABLE IF NOT EXISTS Artist (
		echonest_id enID PRIMARY KEY,
		musicbrainz_id mbID UNIQUE, 
		name varchar(200),
		hotttnesss popularity_index,
		familiarity popularity_index);";

		if (mysqli_query($con, $sql)) {
		    echo "Table Artist created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($con);
		}

		// sql to create Performance table
		$sql = "CREATE TABLE IF NOT EXISTS Performance (
		song enID,
		artist enID, 
		genre varchar(200) NULL,
		FOREIGN KEY song REFERENCES Song(echonest_id),
		FOREIGN KEY artist REFERENCES Artist(echonest_id),
		PRIMARY KEY(artist, song));";

		if (mysqli_query($con, $sql)) {
		    echo "Table Performance created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($con);
		}
		
			// sql to create Listener table
		$sql = "CREATE TABLE IF NOT EXISTS Listener (
			master_id int AUTO_INCREMENT PRIMARY KEY,
			echonest_id enID NULL UNIQUE,
			musicbrainz_id mbID NULL UNIQUE,
			username varchar(60) NULL
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listener created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($con);
		}


		// sql to create Tag table
		$sql = "CREATE TABLE IF NOT EXISTS Tag (
		song enID,
		tag VARCHAR(200) NOT NULL,
		type tag_type NOT NULL,
		listener int,
		FOREIGN KEY (song) REFERENCES Song(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		PRIMARY KEY(song, listener),
		CONSTRAINT ck_tag_type CHECK(type IN ('echonest', 'musicbrainz'))
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Tag created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($conn);
		}

		// sql to create Favorite_Songs table
		$sql = "CREATE TABLE IF NOT EXISTS Favorite_Songs (
		listener int,
		song enID,
		FOREIGN KEY (song) REFERENCES Song(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		PRIMARY KEY(song, listener)
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Favorite_Songs created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($con);
		}

		// sql to create Listens_To_Artist table
		$sql = "CREATE TABLE IF NOT EXISTS Listens_To_Artist (
		listener int,
		artist enID,
		FOREIGN KEY (artist) REFERENCES Artist(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		PRIMARY KEY(artist, listener)
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listens_To_Artist created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($con);
		}

		// sql to create Listens_To_Song table
		$sql = "CREATE TABLE IF NOT EXISTS Listens_To_Song (
		listener int,
		song enID,
		playcount int DEFAULT 1,
		FOREIGN KEY (song) REFERENCES Song(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		PRIMARY KEY(song, listener),
		CONSTRAINT ck_playcount CHECK (playcount >= 1)
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listens_To_Song created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($con);
		}
	}

	$sql = "INSERT INTO Song (firstname, lastname, email)
	 VALUES ('John', 'Doe', 'john@example.com')";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}



 	mysqli_close($con);
 ?>
</body>
</html>
