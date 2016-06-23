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
		sevendigital_id sevenDID NULL UNIQUE, 
		title varchar(100) NOT NULL,
		release_year int NOT NULL, 
		release varchar(200) NOT NULL,
		loudness decimal NOT NULL,
		hotttnesss popularity_index NOT NULL,
		tempo float NOT NULL,
		song_key int NOT NULL,
		mode int NOT NULL,
		start decimal NOT NULL,
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
		musicbrainz_id mbID NOT NULL UNIQUE, 
		name varchar(200) NOT NULL,
		hotttnesss popularity_index NOT NULL,
		familiarity popularity_index NOT NULL);";

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
			username varchar(60) NULL,
			CONSTRAINT ck_ids CHECK(username IS NOT NULL OR musicbrainz_id IS NOT NULL OR echonest_id IS NOT NULL)
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listener created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($con);
		}

		// sql to set Listener table's auto-increment intial value to 1
		$sql = "ALTER TABLE Listener AUTO_INCREMENT=1";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listener increment initial value set successfully";
		} else {
		    echo "Error setting initial increment value: " . mysqli_error($con);
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

	$sql = "INSERT INTO Song (echonest_id, sevendigital_id, title, release_year, release, loudness, hotttnesss, tempo, song_key, mode, start)
	 VALUES ('123456789asdfghjkl', 187, 'Live Your Life', 1987, 'Alligators will cry', 20.2, 98.2, 20.2, 10, 10, 0.00)";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	$sql = "INSERT INTO Artist (echonest_id, musicbrainz_id, name, hotttnesss, familiarity)
	 VALUES ('qwertyuiopzxcvbnml', '456e4567-e89b-12d3-a456-426655440000', 'J-Swizza', 72.4, 100.0)";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	$sql = "INSERT INTO Listener (echonest_id, musicbrainz_id, username)
	 VALUES ('asdfghjklqwertyuio', '123e4567-e89b-12d3-a456-426655440000', 'caligirl46')";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	$sql = "INSERT INTO Performance (song, artist, genre)
	 VALUES ('123456789asdfghjkl', 'qwertyuiopzxcvbnml', 'rock')";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	$sql = "INSERT INTO Listens_To_Song (listener, song)
	 VALUES (1, '123456789asdfghjkl')";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	$sql = "INSERT INTO Listens_To_Artist (listener, artist)
	 VALUES (1, 'qwertyuiopzxcvbnml')";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	$sql = "INSERT INTO Tag (song, tag, type, listener)
	 VALUES ('123456789asdfghjkl', 'swedish_death_metal', 'echonest', 1)";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}



 	mysqli_close($con);
 ?>
</body>
</html>
